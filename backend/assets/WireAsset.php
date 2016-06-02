<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WireAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets';
//	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/wire.css',
		'css/tagsort.css',
		'css/cd-panel.css',
		'css/cd-timeline.css',
		'css/materialadmin.css',
		'snd',
    ];
    public $js = [
		'js/tagsort.min.js',
		'js/sortElements.js',
		'js/wire.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    	'frontend\assets\MetarAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
