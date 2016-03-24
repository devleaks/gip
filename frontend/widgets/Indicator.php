<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

/**
 * Indicator widget renders a single indicator
 *
 */
class Indicator extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $color = 'aqua';
    public $colorBG = false;
	public $title = 'Title';
	public $titleIcon = 'fa-envelope-o';
	public $count = 0;
	public $item = 'Mail';
	public $icon = 'fa-envelope-o';
	public $progress = 0;
	public $progressDescription = '% done';
	
	public function run() {		
        return $this->render('indicator', [
            'widget' => $this,
        ]);
	}
}
