<?php

use \dosamigos\leaflet\types\LatLng;
use \dosamigos\leaflet\layers\Marker;
use \dosamigos\leaflet\layers\TileLayer;
use \dosamigos\leaflet\LeafLet;
use \davidjeddy\leaflet\plugins\draw\Draw;

$this->title = Yii::t('gip', 'Zone Editor');
$this->params['breadcrumbs'][] = $this->title;


$this->registerCss('#export {
	position: absolute;
	top:190px;
	right:24px;
	z-index:1000;
	background:white;
	color:black;
	padding:6px;
	border-radius:4px;
	font-family: "Helvetica Neue";
	cursor: pointer;
	font-size:16px;
	text-decoration:none;
}');

    // The Tile Layer (very important)
    $tileLayer = new TileLayer([
       'urlTemplate' => 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'clientOptions' => [
            'attribution' => 'Tiles Courtesy <a href="http://openstreetmap.org">OpenStreetMap</a>'
        ]
    ]);

    // now our component and we are going to configure it
    $leaflet = new LeafLet([
        'center' => new LatLng(['lat' => 50.639, 'lng' => 5.450]),
		'zoom' => 14
    ]);

	// init the 2amigos leaflet plugin provided by the package
    $drawFeature = new Draw();
	// optional config array for leadlet.draw
    $drawFeature->options = [
        "position" => "topright",
        "draw" => [
            "polygon" => [
                "allowIntersection" => false, // Restricts shapes to simple polygons
                "drawError" => [
                    "color" => "#e1e100", // Color the shape will turn when intersects
                    "message" => "You cannot cross polygon lines" // Message that will show when intersect
                ],
                "shapeOptions" => [
                    "color" => "#bada55"
                ]
            ],
			"marker" => false,
        	"polyline" => false,
            "circle" => false,
            "rectangle" => false
        ]
    ];

    // Different layers can be added to our map using the `addLayer` function.
    $leaflet->addLayer($tileLayer)          // add the tile layer
            ->installPlugin($drawFeature);  // add draw plugin

	$leaflet->appendJs('$("#export").click(function(e){save_json(drawnItems.toGeoJSON())})');

?>
<a href='#' id='export'><i class="fa fa-save"></i></a>
<div class="zone-editor-index">
<?= $leaflet->widget(['options' => ['style' => 'min-height: 700px']]) ?>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_LEAFLETDRAW') ?>
function save_json(s) {
	console.log('save_json', s);
}
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_LEAFLETDRAW'], yii\web\View::POS_BEGIN);
