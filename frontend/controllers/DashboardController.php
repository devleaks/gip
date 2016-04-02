<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
	public $layout = '//main';
	
	private $metar_url = 'http://aviationweather.gov/adds/metars/?station_ids=XXXX&std_trans=standard&chk_metars=on&hoursStr=most+recent+only&submitmet=Submit';

    /**
     * Display whole dashboard
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Update widget action
     */
	public function actionUpdate() {
		$value = date('s', time());
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['r' => $value]);
	}


    /**
     * Update widget action
     */
	protected function getTextBetweenTags($string) {
	    $pattern = '/<FONT FACE="Monospace,Courier">(.*?)<\/FONT>/';
	    preg_match($pattern, $string, $matches);
	    return $matches[1];
	}
	
	protected function getHtml($url, $post = null) {
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

	public function actionMetar() {
		$icao = Yii::$app->request->post('icao', 'EBBR');
		$url = str_replace('XXXX', $icao, $this->metar_url);
		$html = $this->getHtml($url);
		$metar = $this->getTextBetweenTags($html);
		
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['metar' => $metar]);
	}
}