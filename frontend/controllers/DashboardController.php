<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
	public $layout = '//main';

    /**
     * Display whole dashboard
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Update widget action
     */
	public function actionUpdate() {
		$value = date('s', time());
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['r' => $value]);
	}
}
