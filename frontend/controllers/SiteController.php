<?php
namespace frontend\controllers;

use frontend\models\ContactForm;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		if(Yii::$app->user->isGuest) {
			$this->layout = '//public';
	        return $this->render('index');
		}
		$now = date('Y-m-d H:i:s');
	    if (Yii::$app->request->post()) {

	        $name = Yii::$app->request->post('name');
	        $message = Yii::$app->request->post('message');

	        return Yii::$app->redis->executeCommand('PUBLISH', [
	            'channel' => 'notification',
	            'message' => Json::encode(['name' => $name, 'message' => $message])
	        ]);

	    }
        return $this->render('welcome');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Search action
     */
	public function actionSearch($q) {
        return $this->render('search', [
			'query' => $q,
        ]);
	}
}
