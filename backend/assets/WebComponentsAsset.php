<?php
/**
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WebComponentsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/webcomponentsjs';
//	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
//		'webcomponents.min.js',
//		'CustomElements.js',
//		'CustomElements.min.js',
//		'HTMLImports.js',
//		'HTMLImports.min.js',
//		'MutationObserver.js',
//		'MutationObserver.min.js',
//		'ShadowDOM.js',
//		'ShadowDOM.min.js',
//		'webcomponents-lite.js',
//		'webcomponents-lite.min.js',
//		'webcomponents.js',
		'webcomponents.min.js',
    ];
    public $depends = [
    ];
}
