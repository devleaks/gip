<?php

namespace backend\widgets;

use frontend\assets\MetarAsset;

use Yii;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Metar widget fetches and renders a Metar string
 *
 */
class Metar extends Giplet
{
	const METAR_URL = 'http://weather.noaa.gov/pub/data/observations/metar/stations/XXXX.TXT';

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
	protected function getTextBetweenTags($string,$pat) {
		return rtrim(substr($string, strpos($string, $pat)));
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

	public static function update($id, $params) {
		Yii::trace('Params '.print_r($params,true), 'Metar::update');
		$errors = null;
		$icao = ArrayHelper::getValue($params, 'icao', 'EBBR');
		$url = str_replace('XXXX', $icao, self::METAR_URL);
		$html = self::getHtml($url);
		Yii::trace('Got '.$html, 'Metar::update');
		$metar = self::getTextBetweenTags($html, $icao);
		if(! $metar) {
			$errors = 'Metar parsing error';
		}
		Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode(['metar' => $metar, 'e' => $errors]);
	}

}
