<?php
namespace frontend\controllers;

use common\models\Dashboard;
use common\models\Giplet;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Dashboard controller
 */
class PolymerController extends Controller
{
	/**
	 * Return Dashboard configuration
	 */
    public function actionDashboard($id) {
        $model = $this->findModel($id);
		$dashboard = $model->attributes;
	
		$giplets = [];
		foreach($model->getGiplets()->orderBy('name')->each() as $giplet) {
			$giplets[] = [
				'id' => $giplet->id,
				'name' => $giplet->name,
				'displayName' => $giplet->display_name,
				'type' => $giplet->type->display_name,
				'typeId' => $giplet->type->name,
				'tag' => $giplet->type->element_name,
			];
		}
		$dashboard['giplets'] = $giplets;
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($dashboard);
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




}