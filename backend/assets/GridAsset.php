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
class GridAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets';
//	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/gridstack.css',
    ];
    public $js = [
		'js/gridstack.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
