<?php

namespace backend\modules\viewer\controllers;

use Yii;
use common\models\Map;
use common\models\MapBackground;
use common\models\MapLayer;
use common\models\MapToolGroup;
use common\models\search\Map as MapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MapController implements the CRUD actions for Map model.
 */
class MapController extends Controller
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
     * Lists all Map models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MapSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Map model.
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
     * Creates a new Map model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Map;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Map model.
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
     * Deletes an existing Map model.
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
     * Finds the Map model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Map the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Map::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	public function actionBackgroundAdd() {
		$model = new MapBackground();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('gip', 'Background added.'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
			Yii::$app->session->setFlash('danger', Yii::t('gip', 'Could not add background.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
	}

	public function actionLayerAdd() {
		$model = new MapLayer();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('gip', 'Layer added.'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
			Yii::$app->session->setFlash('danger', Yii::t('gip', 'Could not add layer.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
	}

	public function actionToolGroupAdd() {
		$model = new MapToolGroup();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('gip', 'Tool set added.'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
			Yii::$app->session->setFlash('danger', Yii::t('gip', 'Could not add tool set.'));
            return $this->redirect(Yii::$app->request->referrer);
        }
	}
}
