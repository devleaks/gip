<?php

namespace common\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';
    public $baseUrl = '@web';
    public $css = [
		'css/map.css',
		'fonts'
    ];
    public $js = [
		'js/L-oscars-util.js',
		'js/L-oscars-device-group.js',
		'js/L-oscars-zone-group.js',
    ];
    public $depends = [
		'dosamigos\leaflet\LeafLetAsset'
    ];
}