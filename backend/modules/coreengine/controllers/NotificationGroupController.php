<?php

namespace backend\modules\coreengine\controllers;

use Yii;
use common\models\Notification;
use common\models\NotificationGroup;
use common\models\search\NotificationGroup as NotificationGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;

/**
 * NotificationGroupController implements the CRUD actions for NotificationGroup model.
 */
class NotificationGroupController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all NotificationGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationGroupSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single NotificationGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

			$outgroup = [];
			foreach(Notification::find()->each() as $notification) {
				$outgroup[$notification->id] = $notification->name;
			}

	        $ingroup = [];
	        foreach ($model->getNotifications()->each() as $notification) {
	            $ingroup[$notification->id] = $notification->name;
	            unset($outgroup[$notification->id]);
	        }

	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        } else {

			$outgroup = [];
			foreach(Notification::find()->each() as $notification) {
				$outgroup[$notification->id] = $notification->name;
			}

	        $ingroup = [];
	        foreach ($model->getNotifications()->each() as $notification) {
	            $ingroup[$notification->id] = $notification->name;
	            unset($outgroup[$notification->id]);
	        }

	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        }
    }

    /**
     * Creates a new NotificationGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotificationGroup;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NotificationGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NotificationGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NotificationGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NotificationGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 * Functions to add/remove from Notification Group
	 */
    private function doAction($group_id, $action)
    {
        $post = Yii::$app->request->post();
        $notifications = $post['items'];
		$group = $this->findModel($group_id);
        $error = [];

        foreach ($notifications as $notification_id) {
			$notification = Notification::findOne($notification_id);
            try {
				if($action === 'add') {
					$group->add($notification);
				} else {
					$group->remove($notification);
				}
            } catch (\Exception $exc) {
                $error[] = $exc->getMessage();
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [$this->actionItemSearch($group_id, 'outgroup',  $post['search_outgroup']),
                $this->actionItemSearch($group_id, 'ingroup', $post['search_ingroup']),
                $error];
    }

    public function actionAdd($group_id)
    {
        return $this->doAction($group_id, 'add');
    }

    public function actionRemove($group_id)
    {
        return $this->doAction($group_id, 'remove');
    }

    public function actionItemSearch($id, $target, $term = '')
    {
		$model = $this->findModel($id);

		$outgroup = [];
		foreach(Notification::find()->each() as $notification) {
			$outgroup[$notification->id] = $notification->name;
		}
			
        $ingroup = [];
        foreach ($model->getNotifications()->each() as $notification) {
            $ingroup[$notification->id] = $notification->name;
            unset($outgroup[$notification->id]);
        }

        $result = [];
        if (!empty($term)) {
            foreach (${$target} as $notification) {
                if (strpos($notification, $term) !== false) {
					$model = Notification::findOne(['name' => $notification]);
                    $result[$model->id] = $notification;
                }
            }
        } else {
            $result = ${$target};
        }
        return Html::renderSelectOptions('', $result);
    }
}
