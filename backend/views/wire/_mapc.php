<?php

use backend\assets\WebComponentsAsset;

use yii\web\JsExpression;
use yii\helpers\Html;

WebComponentsAsset::register($this);
$this->registerLinkTag([
    'rel' => 'import',
    'href' => '@vendor/bower/leaflet-map/leaflet-map.html',
]);
?>
<leaflet-map fit-to-markers>
	<leaflet-marker longitude="77.2" latitude="28.4">
		Marker I
	</leaflet-marker>
	<leaflet-circle longitude="77.2" latitude="28.4" radius="300">
		Round
	</leaflet-circle>
</leaflet-map>
