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
		'css/jquery.growl.css',
    ];
    public $js = [
		'js/tagsort.min.js',
		'js/sortElements.js',
		'js/jquery.growl.js',
//		'js/wire.js',
//		'js/wire-widget.js',
    ];
    public $depends = [
    ];
}
