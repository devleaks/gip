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
                        'actions' => ['index', 'search', 'wire', 'read', 'seed', 'get-metar', 'get-movements', 'get-table', 'get-delay'],
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
	
	public function actionGetMovements() {
		$around = Yii::$app->request->post('around');

		$hours = 4;		// hours
		$bucket = 600;	// seconds
		
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("select
		       movement_direction as dir,
		       count(movement_direction) as count,
		       :bucket * round(unix_timestamp(scheduled_time_of_departure)/:bucket) as sched
		  from movement_eblg
		 where least(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) < date_add(:around_datetime, interval :window hour)
		   and greatest(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) > date_sub(:around_datetime, interval :window hour)
		 group by sched
		 order by sched", [':around_datetime' => $around, ':window' => $hours, ':bucket' => $bucket]);
		$sched = $command->queryAll();
		
		$command = $connection->createCommand("select
		       movement_direction as dir,
			   count(movement_direction) as count,
		       :bucket * round(unix_timestamp(scheduled_time_of_departure)/:bucket) as actual
		  from movement_eblg
		 where least(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) < date_add(:around_datetime, interval :window hour)
		   and greatest(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) > date_sub(:around_datetime, interval :window hour)
		   and actual_time_of_departure <= :around_datetime
		 group by movement_direction, actual
		 order by actual", [':around_datetime' => $around, ':window' => $hours, ':bucket' => $bucket]);
		$act = $command->queryAll();
		
		$command = $connection->createCommand("select
		       movement_direction as dir,
			   count(movement_direction) as count,
		       :bucket * round(unix_timestamp(scheduled_time_of_departure)/:bucket) as planned
		  from movement_eblg
		 where least(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) < date_add(:around_datetime, interval :window hour)
		   and greatest(scheduled_time_of_departure, estim_time_of_departure, actual_time_of_departure) > date_sub(:around_datetime, interval :window hour)
		   and actual_time_of_departure > :around_datetime
		 group by movement_direction, planned
		 order by planned", [':around_datetime' => $around, ':window' => $hours, ':bucket' => $bucket]);
		$plan = $command->queryAll();

		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['sched' => $sched, 'plan' => $plan, 'act' => $act]);
	}
	
	/**
	 * {
	    "registration":"OO-123",
	    "flight_number":"SN 123",
	    "destination":"Alicante",
	    "schedule":"14:30",
	    "estimated":"15:10",
	    "actual":"-",
	    "delay":"40"
	  }
	 */
	public function actionGetTable() {
		$around = Yii::$app->request->post('around');
		$what = Yii::$app->request->post('what');
		$size = 6;
		$what = strtolower($what);
		$act = ($what == 'd') ? 'actual_time_of_departure' : 'actual_time_of_arrival';
		$est = ($what == 'd') ? 'estim_time_of_departure' : 'estim_time_of_arrival';
		$src = 'aerodrome_icao_code';
		$oby = ($what == 'd') ? 'scheduled_time_of_departure' : 'scheduled_time_of_arrival';
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("select
		       registration,
			   flight_number,
			   aerodrome_icao_code as airport,
			   date_format(".$oby.", '%H:%i') as schedule,
			   date_format(".$est.", '%H:%i') as estimated
		  from movement_eblg
		 where movement_direction = :what
		   and ".$act." > :around_datetime
		 order by ".$oby." limit ".$size, [':around_datetime' => $around, ':what' => $what]);
		$tab = $command->queryAll();
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($tab);
	}

	public function actionGetDelay() {
		$around = Yii::$app->request->post('around');
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("select
		      iata_delay_code as code,
		      iata_delay_description as reason,
		      sum(delay) as time,
		      round(sum(delay)/(SELECT sum(delay) FROM movement_eblg_delays where actual < :around_datetime) * 100) as percent
		from movement_eblg_delays
		where actual < :around_datetime
		group by iata_delay_code, iata_delay_description
		order by delay desc", [':around_datetime' => $around]);
		$res = $command->queryAll();
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($res);
	}

}