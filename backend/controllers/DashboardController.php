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
class DashboardController extends Controller
{
    /**
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
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
     * Displays a single Background model.
     * @param integer $id
     * @return mixed
     */
    public function actionDesign($id)
    {
        $model = $this->findModel($id);
        return $this->render('design', ['model' => $model]);
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

    /**
     * Update widget action
     */
	public function actionUpdate() {
		$widget = Yii::$app->request->post('name');
		Yii::trace('widget='.$widget, 'DashboardController::actionUpdate');
		return $widget::update();
		if($giplet = Giplet::findOne($giplet_id)) {
			$widget = $giplet->gipletType->factory;
			return $widget::update();
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['error' => 'Giplet not found']);
	}

	/**
	 * Add access rules if needed for getMessage
	 */
    public function actionGetGiplets() {
		$giplets = [];
		foreach(Giplet::find()->orderBy('name')
							->each() as $model) {
			$giplets[] = [
				'id' => $model->id,
				'name' => $model->name,
				'displayName' => $model->display_name,
				'type' => $model->type->display_name,
			];
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($giplets);
    }


	public function actionSaveLayout($id) {
        $model = $this->findModel($id);
		$content = Yii::$app->request->post('content');
		Yii::trace($content, 'DashboardController::actionSaveLayout');
	}

}