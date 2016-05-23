<?php

namespace backend\modules\coreengine\controllers;

use Yii;
use common\models\Zone;
use common\models\ZoneGroup;
use common\models\search\ZoneGroup as ZoneGroupSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * ZoneGroupController implements the CRUD actions for ZoneGroup model.
 */
class ZoneGroupController extends Controller
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
     * Lists all ZoneGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZoneGroupSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ZoneGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

			$outgroup = [];
			foreach(Zone::find()->each() as $zone) {
				$outgroup[$zone->id] = $zone->name;
			}

	        $ingroup = [];
	        foreach ($model->getZones()->each() as $zone) {
	            $ingroup[$zone->id] = $zone->name;
	            unset($outgroup[$zone->id]);
	        }

	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        } else {

			$outgroup = [];
			foreach(Zone::find()->each() as $zone) {
				$outgroup[$zone->id] = $zone->name;
			}

	        $ingroup = [];
	        foreach ($model->getZones()->each() as $zone) {
	            $ingroup[$zone->id] = $zone->name;
	            unset($outgroup[$zone->id]);
	        }

			if($model->errors) {
				Yii::$app->session->setFlash('error', Yii::t('gip', 'There was an error saving the model: {0}.', VarDumper::dumpAsString($model->errors, 4, true))); 			
				Yii::trace('errors '.print_r($model->errors, true), 'ZoneGroupController::actionView');
			}

	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        }
    }

    /**
     * Creates a new ZoneGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZoneGroup;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ZoneGroup model.
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
     * Deletes an existing ZoneGroup model.
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
     * Finds the ZoneGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZoneGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZoneGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 * Functions to add/remove from Zone Group
	 */
    private function doAction($group_id, $action)
    {
        $post = Yii::$app->request->post();
        $zones = $post['items'];
		$group = $this->findModel($group_id);
        $error = [];

        foreach ($zones as $zone_id) {
			$zone = Zone::findOne($zone_id);
            try {
				if($action === 'add') {
					$group->add($zone);
				} else {
					$group->remove($zone);
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
		foreach(Zone::find()->each() as $zone) {
			$outgroup[$zone->id] = $zone->name;
		}
			
        $ingroup = [];
        foreach ($model->getZones()->each() as $zone) {
            $ingroup[$zone->id] = $zone->name;
            unset($outgroup[$zone->id]);
        }

        $result = [];
        if (!empty($term)) {
            foreach (${$target} as $zone) {
                if (strpos($zone, $term) !== false) {
					$model = Zone::findOne(['name' => $zone]);
                    $result[$model->id] = $zone;
                }
            }
        } else {
            $result = ${$target};
        }
        return Html::renderSelectOptions('', $result);
    }

}
