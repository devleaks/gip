<?php

namespace frontend\widgets;

use frontend\assets\MetarAsset;

/**
 * Metar widget fetches and renders a Metar string
 *
 */
class Metar extends \yii\bootstrap\Widget
{
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

}
