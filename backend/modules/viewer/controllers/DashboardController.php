<?php

namespace backend\modules\viewer\controllers;

use Yii;
use common\models\Dashboard;
use common\models\search\Dashboard as DashboardSearch;
use common\models\DashboardGiplet;
use common\models\Giplet;

use yii\web\Response;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class DashboardController extends Controller
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Dashboard model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dashboard;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dashboard model.
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
     * Deletes an existing Dashboard model.
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
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	public function actionGipletAdd() {
		$model = new DashboardGiplet();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('gip', 'Giplet added.'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
			Yii::$app->session->setFlash('danger', Yii::t('gip', 'Could not add giplet.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
	}

    /**
     * Displays a single Background model.
     * @param integer $id
     * @return mixed
     */
    public function actionDesign($id)
    {
        $model = $this->findModel($id);
        return $this->render('design', ['model' => $model]);
    }

	/**
	 * Add access rules if needed for getMessage
	 */
    public function actionGetGiplets($id) {
        $model = $this->findModel($id);
	
		$giplets = [];
		foreach($model->getGiplets()->orderBy('name')->each() as $model) {
			$giplets[] = [
				'id' => $model->id,
				'name' => $model->name,
				'displayName' => $model->display_name,
				'type' => $model->type->display_name,
				'typeId' => $model->type->name,
			];
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($giplets);
    }


	public function actionSaveLayout($id) {
        $model = $this->findModel($id);
		$content = Yii::$app->request->post('content');
		if($content != '') {
			$model->layout = $content;
			$model->save();
			// return success::model saved
		}
		// return warning or error::model not saved
	}


}
