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
class DashboardDesignAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower';
//	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'gridmanager.js/dist/css/jquery.gridmanager-light.css',
		'dynatable/jquery.dynatable.css'
    ];
    public $js = [
		'gridmanager.js/dist/js/jquery.gridmanager.js',
		'dynatable/jquery.dynatable.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
		'yii\jui\JuiAsset',
    ];
}
