<?php

use perspectivain\mapbox\MapboxAPIHelper;

use yii\web\JsExpression;
use yii\helpers\Html;

MapboxAPIHelper::registerScript($this, ['drawing']);
?>
<div id='map' style="height: 900px;"></div>
<script type="text/javascript">
<?php $this->beginBlock('JS_MAPBOX') ?>

	L.mapbox.accessToken = "<?= Yii::$app->params['MAPBOX_API_TOKEN'] ?>";
	var map = L.map('map', 'mapbox.comic');
	var marker = L.marker([50.63639,5.44278], {}).bindPopup("Hi! "+new Date()).addTo(map);
	var layer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {"attribution":"&copy; <a href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors"}).addTo(map);
	/**
	var layer = L.tileLayer('http://a.tiles.mapbox.com/v4/pmareschal.244ffa0b/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoicG1hcmVzY2hhbCIsImEiOiJjaWZmYjhwN3cwMGpudGVseDI3c214czgyIn0.z3SZzxcqSANBIACOMWDfbQ', {"attribution":"&copy; <a href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors"}).addTo(map);
	*/
	// mapbox://styles/pmareschal/ciq2b8y34004mcqm702io07os
	//var styleLayer = L.mapbox.styleLayer('mapbox://styles/../v4/pmareschal.244ffa0b').addTo(map);
	map.setView([50.63639,5.44278], 13);

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_MAPBOX'], yii\web\View::POS_READY);