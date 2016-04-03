<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

/**
 * Indicator widget renders a single value indicator (title + icon + value)
 *
 */
class Indicator extends \yii\bootstrap\Widget
{
    public $color = 'aqua';
    public $colorBG = false;
	public $title = 'Title';
	public $titleIcon = 'fa-info-circle';
	public $value = 0;
	public $item = 'Item';
	public $icon = 'fa-info';
	public $progress = 0;
	public $progressDescription = '% done';
	public $autoUpdate = 0;
	
	public function run() {		
        return $this->render('indicator', [
            'widget' => $this,
        ]);
	}
}
