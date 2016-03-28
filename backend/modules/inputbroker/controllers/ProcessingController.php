<?php

namespace backend\modules\inputbroker\controllers;

use Yii;
use common\models\Processing;
use common\models\Mapping;
use common\models\search\Processing as ProcessingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProcessingController implements the CRUD actions for Processing model.
 */
class ProcessingController extends Controller
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
     * Lists all Processing models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcessingSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Processing model.
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
     * Creates a new Processing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Processing;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Processing model.
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
     * Deletes an existing Processing model.
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
     * Finds the Processing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Processing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Processing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	public function actionMappings() {
		if($mpost = Yii::$app->request->post('Mapping')) {
			$mids = array_keys($mpost);
			$models = Mapping::find()->where(['id' => $mids])->indexBy('id')->all();

			if (Mapping::loadMultiple($models, Yii::$app->request->post()) && Mapping::validateMultiple($models)) {
		        $count = 0;
		        foreach ($models as $index => $model) {
		            // populate and save records for each model
					// Yii::trace('doing '.$model->id, 'ProcessingController::actionMappings');
		            if ($model->save()) {
		                $count++;
					}
		        }
		        Yii::$app->session->setFlash('success', "Updated {$count} attribute(s) successfully.");
		    } else {
		        Yii::$app->session->setFlash('danger', "Error while saving attributes.");
		    }
		} else {
		    Yii::$app->session->setFlash('danger', "Mapping is not set.");
		}
		return $this->redirect(Yii::$app->request->referrer);
 	}
}
