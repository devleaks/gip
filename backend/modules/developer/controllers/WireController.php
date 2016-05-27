<?php

namespace backend\modules\developer\controllers;

use common\models\Wire;
use common\models\search\Wire as WireSearch;

use WebSocket\Client as WebsocketClient;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WireController implements the CRUD actions for Wire model.
 */
class WireController extends Controller
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

		if($client = new WebsocketClient(Yii::$app->params['websocket_server'])) {
			$client->send($model->body);
			$feedback = 'Message sent';
		} else {
			$feedback = 'Error';
		}
		
		/*
		$client = new WebsocketClient;
		if( $client->connect('imac.local', 8051, '/gipadmin/site/wire/', 'index.php') ) {
			$payload = json_encode(['message' => $model->body]) . "\n\r";
			$client->sendData($payload);
			return $payload;
		} else {
			return 'Error connecting...';
		}
/*
		$client = stream_socket_client('tcp://imac.local:8051/', $errorNumber, $errorString);
        if ($client) {
			stream_set_blocking($client, 0);
            fwrite($client, json_encode(['message' => $model->body]) . "\n\r");
			fclose($client);
			$feedback = 'Message '.$model->body.' sent.';
        } else {
			$feedback = 'Error: '.$errorNumber.': '.$errorString.'.';
        }
*/
		return $feedback;
	}

}
