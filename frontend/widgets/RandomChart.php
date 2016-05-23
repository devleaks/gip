<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use Yii;
use yii\web\Response;
use yii\helpers\Json;

/**
 * Indicator widget renders a single value indicator (title + icon + value)
 *
 */
class RandomChart extends \yii\bootstrap\Widget
{

	public function run() {		
        return $this->render('highcharts', [
            'widget' => $this,
        ]);
	}
}
