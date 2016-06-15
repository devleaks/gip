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
class DashboardAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets';
//	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/cd-panel.css',
		'css/cd-timeline.css',
		'css/materialadmin.css',
		'snd',
//		'css/waves.css'
    ];
    public $js = [
		'js/dashboard.js',
		'js/jspath.js',
//		'js/waves.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
