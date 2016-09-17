<?php
namespace backend\controllers;

use common\models\Dashboard;
use common\models\search\Dashboard as DashboardSearch;
use common\models\Giplet;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Dashboard controller
 */
class DataCollectorController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
	{            
	    if ($action->id == 'collect') {
	        $this->enableCsrfValidation = false;
	    }

	    return parent::beforeAction($action);
	}
	    /**
     * Collect data action
     */
	public function actionCollect() {
		$post = Yii::$app->request->post();
		Yii::trace('post='.print_r($post, true), 'DataCollectorController::actionCollect');
	}

}