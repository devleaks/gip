<?php

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

use yii\web\JsExpression;
use yii\helpers\Html;


// first lets setup the center of our map
$mapCenter = new LatLng(['lat' => $center['lat'], 'lng' => $center['lon']]);

// now lets create a marker that we are going to place on our map
$marker = new Marker(['latLng' => $mapCenter, 'popupContent' => 'Hi!']);

// The Tile Layer (very important)
$tileLayer = new TileLayer([
   'urlTemplate' => 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
    'clientOptions' => [
        'attribution' => '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    ]
]);

// now our component and we are going to configure it
$leaflet = new LeafLet([
    'center' => $mapCenter, // set the center
	'zoom' => $zoom
]);
// Different layers can be added to our map using the `addLayer` function.
$leaflet->addLayer($marker)      // add the marker
        ->addLayer($tileLayer);  // add the tile layer

// finally render the widget
echo Map::widget([
	'leafLet' => $leaflet,
	'height' => $height,
]);
// we could also do
// echo $leaflet->widget();