<?php
namespace backend\controllers;

use common\models\Wire;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class WireController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'search', 'wire', 'read', 'seed', 'get-metar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','read'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists Wire models already published.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
			'query' => Wire::find()
				->andWhere([ 'status' => Wire::STATUS_PUBLISHED ])
				->orderBy('created_at desc')
		]);

		$this->layout = 'wire';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionRead() {
		$id = ArrayHelper::getValue($_POST, 'id');
        $model = $this->findModel($id);
		$model->status = Wire::STATUS_PUBLISHED;
		$model->ack_at = date('Y-m-d H:i:s');
		$model->save();
	}

    protected function findModel($id)
    {
        if (($model = Wire::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Search action
     */
	public function actionSearch($q) {
        return $this->render('search', [
			'query' => $q,
        ]);
	}

	/**
	 * Add access rules if needed for getMessage
	 */
    public function actionSeed() {
		$max_messages = 10;
		$messages = [];
		foreach(Wire::find()->andWhere([ 'status' => Wire::STATUS_PUBLISHED ])
							->orderBy('created_at desc')
							->limit($max_messages)
							->each() as $model) {
			$messages[] = array_merge( // add source and type names rather than ids.
							$model->attributes,
							[
								'source' => $model->source ? $model->source->name : 'unknown',
								'type' => $model->type ? $model->type->name : 'unknown'
							]);
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($messages);
    }

	/**
	 * Update Giplet value
	 */
	protected static function getHtml($url, $post = null) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    if(!empty($post)) {
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	    } 
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}

	public static function actionGetMetar() {
		$errors = null;
		$icao = 'EBLG';
		$html = self::getHtml('http://weather.noaa.gov/pub/data/observations/metar/stations/'.strtoupper($icao).'.TXT');
		Yii::trace('Got '.$html, 'Metar::update');
		$metar = rtrim(substr($html, strpos($html, $icao)));
		if(! $metar) {
			$errors = 'Metar parsing error';
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['metar' => $metar, 'e' => $errors]);
	}

}
