<?php
namespace frontend\controllers;

use common\models\Dashboard;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
    /**
     * Display whole dashboard
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Update widget action.
     * Fetches parameters, if any, instanciate giplet, and call update on it.
     */
	public function actionUpdate() {
		$giplet_type = Yii::$app->request->post('name', null);
		if($giplet_type) {
			$giplet_id = Yii::$app->request->post('id', null);
			$giplet_params = Yii::$app->request->post('params', null);
			if($giplet_id) { // call update function of giplet
				$giplet = new $giplet_type();
				return $giplet->update($giplet_id, $giplet_params);
			}
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['r' => null, 'e' => 'no post data']);
	}


    /**
     * Displays a single Background model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Finds the Background model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Background the loaded model
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