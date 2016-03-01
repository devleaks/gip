<?php

namespace backend\modules\common\controllers;

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

    /**
     * Batch Updates an set of existing AttributeValues.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBatchUpdate() {
		if(isset($_POST['AttributeValue'])) {
			$avpost = $_POST['AttributeValue'];
			$avids = array_keys($avpost);
			$models = AttributeValue::find()->where(['id' => $avids])->indexBy('id')->all();
	//	    $sourceModel = new AttributeValueSearch;
	//	    $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams());
	//	    $models = $dataProvider->query->indexBy('id')->all();

			if (AttributeValue::loadMultiple($models, Yii::$app->request->post()) && AttributeValue::validateMultiple($models)) {
		        $count = 0;
		        foreach ($models as $index => $model) {
		            // populate and save records for each model
					Yii::trace('doing '.$model->id, 'AttributeValueController::actionBatchUpdate');
		            if ($model->save()) {
		                $count++;
					}
		        }
		        Yii::$app->session->setFlash('success', "Updated {$count} attribute(s) successfully.");
		    } else {
		        Yii::$app->session->setFlash('danger', "Error while saving attributes.");
		    }
		} else {
		    Yii::$app->session->setFlash('danger', "AttributeValue is not set.");
		}
		return $this->redirect(Yii::$app->request->referrer);
	}

}
