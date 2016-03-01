<?php

namespace backend\modules\inputbroker\controllers;

use Yii;
use common\models\AttributeValue;
use common\models\search\AttributeValue as AttributeValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttributeValueController implements the CRUD actions for AttributeValue model.
 */
class AttributeValueController extends Controller
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

    public function index()
    {
		return 'hello';
	}

    /**
     * Batch Updates an set of existing AttributeValues.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBatchUpdate() {
	    $sourceModel = new AttributeValueSearch;
	    $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams());
	    $models = $dataProvider->getModels();
		Yii::trace('entering... '.count($models), 'AttributeValueController::actionBatchUpdate');
	    if (AttributeValue::loadMultiple($models, Yii::$app->request->post()) && AttributeValue::validateMultiple($models)) {
	        $count = 0;
	        foreach ($models as $index => $model) {
				Yii::trace('doing '.$model->id, 'AttributeValueController::actionBatchUpdate');
	            // populate and save records for each model
	            if ($model->save()) {
					Yii::trace('saved '.$model->id, 'AttributeValueController::actionBatchUpdate');
	                $count++;
	            } else {
					Yii::trace('errors '.print_r($model->errors, true), 'AttributeValueController::actionBatchUpdate');
				}
	        }
	        Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
	    } else {
	        Yii::$app->session->setFlash('danger', "Error while saving attributes.");
	    }
		return $this->redirect(Yii::$app->request->referrer);
	}

}
