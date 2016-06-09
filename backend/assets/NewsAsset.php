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
class NewsAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets';
    public $baseUrl = '@web';
    public $css = [
		'css/breakingNews.css',
    ];
    public $js = [
		'js/breakingNews.js',
    ];
    public $depends = [
    ];
}
