<?php

namespace frontend\widgets;

use frontend\assets\MetarAsset;

use Yii;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Metar widget fetches and renders a Metar string
 *
 */
class Metar extends \yii\bootstrap\Widget
{
	const METAR_URL = 'http://aviationweather.gov/adds/metars/?station_ids=XXXX&std_trans=standard&chk_metars=on&hoursStr=most+recent+only&submitmet=Submit';

    public $location = 'EBBR';
	
	public function run() {
		$this->registerAssets();
        return $this->render('metar', [
            'widget' => $this,
        ]);
	}

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        MetarAsset::register($view);
    }

	/**
	 * Update Giplet value
	 */
	protected static function getTextBetweenTags($string) {
	    $pattern = '/<FONT FACE="Monospace,Courier">(.*?)<\/FONT>/';
	    preg_match($pattern, $string, $matches);
	    return isset($matches[1])?$matches[1]:'';
	}

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

	public static function update() {
		$errors = '';
		$icao = Yii::$app->request->post('icao', 'EBBR');
		$url = str_replace('XXXX', $icao, self::METAR_URL);
		$html = self::getHtml($url);
		$metar = self::getTextBetweenTags($html);
		if(! $metar) {
			$errors = 'HTML FONT parsing error';
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['metar' => $metar, 'errors' => $errors]);
	}

}
