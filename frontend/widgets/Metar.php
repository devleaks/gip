<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

/**
 * Metar widget fetches and renders a Metar string
 *
 */
class Metar extends \yii\bootstrap\Widget
{
    public $location = 'EBBR';
	
	public function run() {	
        return $this->render('metar', [
            'widget' => $this,
        ]);
	}
}
