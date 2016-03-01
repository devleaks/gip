<?php

namespace backend\modules\common\controllers;

use Yii;
use common\models\EntityAttribute;
use common\models\search\EntityAttribute as EntityAttributeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EntityAttributeController implements the CRUD actions for EntityAttribute model.
 */
class EntityAttributeController extends Controller
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
     * Lists all EntityAttribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntityAttributeSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single EntityAttribute model.
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
     * Creates a new EntityAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntityAttribute;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EntityAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EntityAttribute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteSimple($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the EntityAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EntityAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntityAttribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
    	$post = Yii::$app->request->post();
    	Yii::trace('Entering delete action');
    	if (Yii::$app->request->isAjax && isset($post['custom_param'])) {
    		if ($this->findModel($id)->delete()) {
    			echo Json::encode([
    				'success' => true,
    				'messages' => [
    					'kv-detail-info' => 'The record # ' . $id . ' was successfully deleted. <a href="' .
    					Url::to(['/test']) . '" class="btn btn-sm btn-info">' .
    					'<i class="glyphicon glyphicon-hand-right"></i>  Click here</a> to proceed.'
    				]
    			]);
    		} else {
    			echo Json::encode([
   					'success' => false,
   					'messages' => [
						'kv-detail-error' => 'Cannot delete the record # ' . $id . '.'
   					]
    			]);
    		}
    		return;
    	} elseif (Yii::$app->request->post()) {
    		$this->findModel($id)->delete();
    		return $this->redirect(Yii::$app->request->referrer);
    	}
    	throw new InvalidCallException("You are not allowed to do this operation. Contact the administrator.");
    }
}
