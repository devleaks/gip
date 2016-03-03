<?php

namespace backend\modules\developer\controllers;

use Yii;
use common\models\Wire;
use common\models\search\Wire as WireSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WireController implements the CRUD actions for Wire model.
 */
class TheController extends Controller
{
    /**
     * Lists all Wire models.
     * @return mixed
     */
    public function actionWire()
    {
		$this->viewPath = '@backend/modules/developer/views/wire';
		
        $searchModel = new WireSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('wire', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
