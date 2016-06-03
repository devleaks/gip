<?php

namespace backend\modules\developer\controllers;

use common\models\Wire;
use common\models\search\Wire as WireSearch;

use backend\models\WebsocketClient;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * WireController implements the CRUD actions for Wire model.
 */
class WireController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                     [
                        'actions' => ['index', 'wire', 'view', 'get', 'seed', 'older'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Wire models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WireSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all Wire models.
     * @return mixed
     */
    public function actionWire()
    {
        $searchModel = new WireSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('wire', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Wire model.
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
     * Creates a new Wire model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wire;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wire model.
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
     * Deletes an existing Wire model.
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
     * Finds the Wire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wire::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionPublish($id) {
        $model = $this->findModel($id);
		$feedback = 'Nothing done';

		/*
		if($client = new WebsocketClient(Yii::$app->params['websocket_server'])) {
			$client->send($model->body);
			$feedback = 'Message sent';
		} else {
			$feedback = 'Error';
		}
		// use backend\models\WebsocketClient;
		$client = new WebsocketClient;
		if( $client->connect('imac.local', 8051, '/', '') ) {
			$payload = json_encode(['message' => $model->body]) . "\n\r";
			$client->sendData($payload);
			return $payload;
		} else {
			return 'Error connecting...';
		}
		*/
		$client = stream_socket_client('tcp://imac.local:8051/', $errorNumber, $errorString, 1);
        if ($client) {
			stream_set_blocking($client, 0);
            fwrite($client, "GET / HTTP/1.1\r\nHost: localhost\r\nUpgrade: websocket\r\nConnection: Upgrade\r\nSec-WebSocket-Key: tQXaRIOk4sOhgoq7SBs43g==\r\nSec-WebSocket-Version: 13\r\n\r\n");
            fwrite($client, json_encode(['message' => $model->body]) . "\n\r");
			fclose($client);
			$feedback = 'Message sent.';
        } else {
			$feedback = 'Error: '.$errorNumber.': '.$errorString.'.';
        }

		return $feedback;
	}
	
	public function actionGet() {
		$id = ArrayHelper::getValue($_POST, 'id');
        $model = $this->findModel($id);

		// get default icon from source if none specified
		if(!$model->icon && $model->source) {
			$model->icon = $model->source->icon;
		}

		// get default color from type if none specified
		if(!$model->color && $model->type) {
			$model->color = $model->type->color;
		}

		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(array_merge( // add source and type names rather than ids.
			$model->attributes,
			[
				'source' => $model->source ? $model->source->name : 'unknown',
				'type' => $model->type ? $model->type->name : 'unknown'
			]
			)
		);
	}

}
