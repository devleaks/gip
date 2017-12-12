<?php

namespace backend\modules\coreengine\controllers;

use Yii;
use common\models\Device;
use common\models\DeviceGroup;
use common\models\search\DeviceGroup as DeviceGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;

/**
 * DeviceGroupController implements the CRUD actions for DeviceGroup model.
 */
class DeviceGroupController extends Controller
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
     * Lists all DeviceGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeviceGroupSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new DeviceGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeviceGroup;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DeviceGroup model.
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
     * Deletes an existing DeviceGroup model.
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
     * Finds the DeviceGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeviceGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeviceGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	 * Functions to add/remove from Device Group
	 */
	
	/**
	 * Build groups of items inside or outside of group supplied
	 */
	private function getGroups($group) {
		$outgroup = [];
		foreach(Device::find()->each() as $item) {
			$outgroup[$item->id] = $item->name;
		}

        $ingroup = [];
        foreach ($group->getDevices()->each() as $item) {
            $ingroup[$item->id] = $item->name;
            unset($outgroup[$item->id]);
        }
		return [$ingroup, $outgroup];
	}

    /**
     * Displays a single DeviceGroup model and its Devices.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			list($ingroup, $outgroup) = $this->getGroups($model);
	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        } else {
			list($ingroup, $outgroup) = $this->getGroups($model);
	        return $this->render('view', [
				'model'	    => $model,
	            'outgroup'  => $outgroup,
	            'ingroup'   => $ingroup,
	        ]);

        }
    }

    /**
     * Displays a single DeviceGroup model and its Devices.
     * @param integer $id
     * @return mixed
     */
    public function actionTojson($id)
    {
    	$model = $this->findModel($id);

		Yii::$app->response->format = Response::FORMAT_JSON;
		
        return $model->toGeoJson();
    }

    private function doAction($group_id, $action)
    {
        $post = Yii::$app->request->post();
        $devices = $post['items'];
		$group = $this->findModel($group_id);
        $error = [];

        foreach ($devices as $device_id) {
			$device = Device::findOne($device_id);
            try {
				if($action === 'add') {
					$group->add($device);
				} else {
					$group->remove($device);
				}
            } catch (\Exception $exc) {
                $error[] = $exc->getMessage();
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [$this->actionItemSearch($group_id, 'outgroup',  $post['search_outgroup']),
                $this->actionItemSearch($group_id, 'ingroup', $post['search_ingroup']),
                $error];
    }

    public function actionAdd($group_id)
    {
        return $this->doAction($group_id, 'add');
    }

    public function actionRemove($group_id)
    {
        return $this->doAction($group_id, 'remove');
    }

    public function actionItemSearch($id, $target, $term = '')
    {
		$model = $this->findModel($id);
		list($ingroup, $outgroup) = $this->getGroups($model);
        $result = [];
        if (!empty($term)) {
            foreach (${$target} as $device) {
                if (strpos($device, $term) !== false) {
					$model = Device::findOne(['name' => $device]);
                    $result[$model->id] = $device;
                }
            }
        } else {
            $result = ${$target};
        }
        return Html::renderSelectOptions('', $result);
    }



}
