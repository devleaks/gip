<?php
namespace backend\controllers;

use common\models\Wire;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['help', 'index', 'search'],
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
     * Default action
     */
    public function actionIndex()
    {
        return $this->render('index');
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
     * List markdown files or render a markdown file if supplied
     */
    public function actionHelp($f = null)
    {
		if(Yii::$app->user->isGuest)
        	return $this->render('index');
		else
        	return $this->render('help', ['file' => $f]);
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
     * Default action
     */
    public function actionMotd()
    {
        return $this->render('motd');
    }

	/**
	 * Add access rules if needed for getMessage
	 */
    public function actionGetMotd() {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        echo "retry: 10000\n\n"; // Optional. We tell the browser to retry after 10 seconds
        foreach(Motd::find()->where(['new' => true])->orderBy('created_at desc')->each() as $message) {
            echo "data: <p>" . $message->message . "</p>\n";
			// $message->new = 0;
			// $message->save();
        }
        flush();
    }

	public function actionMessage() {
        $sse = new \common\components\SSE();
        $counter = rand(1, 10);
        $t = time();

        //$sse->retry(3000);
        while ((time() - $t) < 15) {
            // Every second, sent a "ping" event.

            $curDate = date(DATE_ISO8601);
            $sse->event('ping',['time' => $curDate]);

            // Send a simple message at random intervals.
            $counter--;
            if (!$counter) {
                $sse->message("This is a message at time $curDate");
                $counter = rand(1, 10);
            }

            $sse->flush();
            sleep(1);
        }
        exit();
    }
}
