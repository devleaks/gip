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
class Clock extends Giplet
{
	public $color;
	
	public function run() {
		$this->registerAssets();
        return $this->render('clock', [
            'widget' => $this,
        ]);
	}

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
    }

}
