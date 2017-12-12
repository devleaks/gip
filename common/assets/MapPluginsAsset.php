<?php

namespace common\assets;

use yii\web\AssetBundle;

class MapPluginsAsset.php  extends AssetBundle
{
    public $sourcePath = '@npm';
    public $baseUrl = '@web';
    public $css = [
	    'leaflet-pulse-icon/dist/L.Icon.Pulse.css',
		'leaflet-groupedlayercontrol/dist/leaflet.groupedlayercontrol.min.css',
		'beautifymarker/leaflet-beautify-marker-icon.css',
		'leaflet-sidebar-v2/css/leaflet-sidebar.css',	
		'leaflet-search/dist/leaflet-search.src.css',	
		'leaflet-easybutton/src/easy-button.css',
		'leaflet/line-awesome/css/line-awesome.css'
    ];
    public $js = [
	    'leaflet-realtime/dist/leaflet-realtime.js',
	    'leaflet-pulse-icon/dist/L.Icon.Pulse.js',
	    'beautifymarker/leaflet-beautify-marker-icon.js',
	    'beautifymarker/leaflet-beautify-marker.js',
		'leaflet-rotatedmarker/leaflet.rotatedMarker.js',
		'leaflet-groupedlayercontrol/dist/leaflet.groupedlayercontrol.min.js',
		'leaflet-sidebar-v2/js/leaflet-sidebar.js',
		'leaflet-canvasicon/leaflet-canvasicon.js',
		'leaflet-piechart/leaflet-piechart.js',
		'leaflet-search/dist/leaflet-search.src.js',
		'leaflet-easybutton/src/easy-button.js',
		'renderjson/renderjson.js',
		'jsonpath-plus/lib/jsonpath.js',
		'mustache/mustache.js',
		'moment/moment.js',
		'@turf/turf/turf.min.js',
		'@mapbox/geojsonhint/geojsonhint.js',
		'peity/jquery.peity.js'
    ];
    public $depends = [
		'dosamigos\leaflet\LeafLetAsset'
    ];
}
