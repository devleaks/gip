<?php

namespace common\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';
    public $baseUrl = '@web';
    public $css = [
//		'leaflet/leaflet-betterscale/L.Control.BetterScale.css',
//		'leaflet/Leaflet.zoomdisplay-master/dist/leaflet.zoomdisplay.css',	
		'css/L-addons.css',
		'css/L-oscars.css',
		'fonts/'
    ];
    public $js = [
//		'leaflet/leaflet-betterscale/L.Control.BetterScale.js',
		'js/L-addons.js',
		'js/L-oscars-util.js',
		'js/L-oscars-device-group.js',
		'js/L-oscars-zone-group.js',
    ];
    public $depends = [
		'dosamigos\leaflet\LeafLetAsset'
    ];
}
