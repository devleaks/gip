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
class News extends Giplet
{
	public $news;
	
	public function run() {
		$this->registerAssets();
        return $this->render('news', [
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
