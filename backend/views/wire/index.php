<?php

use common\models\Wire as WireModel;
use backend\widgets\Wire;

use devleaks\weather\Weather;

use bburim\flot\Chart;
use bburim\flot\Plugin;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

$this->title = 'GIP - Live Wire';
?>
<div class="wire container-fluid">
	
	<div class="row">

		<div class="col-lg-9">

			<div class="row">
				<div class="col-lg-12">
					<?php 

					// first lets setup the center of our map
					$center = new LatLng(['lat' => 50.63639, 'lng' => 5.44278]);

					// now lets create a marker that we are going to place on our map
					$marker = new Marker(['latLng' => $center, 'popupContent' => 'Hi!']);

					// The Tile Layer (very important)
					$tileLayer = new TileLayer([
					   'urlTemplate' => 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
					    'clientOptions' => [
					        'attribution' => '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
					    ]
					]);

					// now our component and we are going to configure it
					$leaflet = new LeafLet([
					    'center' => $center, // set the center
					]);
					// Different layers can be added to our map using the `addLayer` function.
					$leaflet->addLayer($marker)      // add the marker
					        ->addLayer($tileLayer);  // add the tile layer

					// finally render the widget
					echo Map::widget([
						'leafLet' => $leaflet,
						'height' => '800px'
					]);
					// we could also do
					// echo $leaflet->widget();
					?>

				</div>
			</div>


			<div class="row">
				<div class="col-lg-12">
					<?= Wire::widget([
						'id' => 'the-wire',
						'statuses' => [WireModel::STATUS_PUBLISHED, WireModel::STATUS_UNREAD],
						'live' => true,
						'wire_count' => 0
					]) ?>
				</div>
			</div>
		</div>
	
		<div class="col-lg-3">


			<div class="row">
				<div class="col-lg-12">
					<?php   echo '<div id="weather"></div>';
							if(isset(Yii::$app->params['FORECAST_APIKEY'])) {
								echo Weather::widget([
									'id' => 'weather',
									'pluginOptions' => [
										'celsius' => true,
										'cacheTime' => 60,
										'key' => Yii::$app->params['FORECAST_APIKEY'],
										'lat' => Yii::$app->params['FORECAST_DEFAULT_LAT'],
										'lon' => Yii::$app->params['FORECAST_DEFAULT_LON'],
									]
								]);
							} else {
								Yii::$app->session->setFlash('error', 'Weather: No API key.');
							}
					?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-12">
					<?= Chart::widget([
					    'data' => [
					        [
					            'label' => 'line', 
					            'data'  => [
					                [1, 1],
					                [2,7],
					                [3,12],
					                [4,32],
					                [5,62],
					                [6,89],
					            ],
					            'lines'  => ['show' => true],
					            'points' => ['show' => true],
					        ],
					    ],
					    'options' => [
					        'legend' => [
					            'position'          => 'nw',
					            'show'              => true,
					            'margin'            => 10,
					            'backgroundOpacity' => 0.5
					        ],
					    ],
					    'htmlOptions' => [
					        'style' => 'width:100%;height:300px;'
					    ],
					    'plugins' => [
					        Plugin::PIE
					    ]
					]);
					?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-12">
					<?= Chart::widget([
					    'data' => [
					        [
					            'label' => 'bars', 
					            'data'  => [
					                [1,12],
					                [2,16],
					                [3,89],
					                [4,44],
					                [5,38],
					            ],
					            'bars' => ['show' => true],
					        ],
					    ],
					    'options' => [
					        'legend' => [
					            'position'          => 'nw',
					            'show'              => true,
					            'margin'            => 10,
					            'backgroundOpacity' => 0.5
					        ],
					    ],
					    'htmlOptions' => [
					        'style' => 'width:100%;height:300px;'
					    ]
					]);
					?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-12">
					<div id="pie-location2" style="width: 100%; height: 300px;">
					<?=
					Chart::widget([
					    'data' => [
					    	['label' => 'Serie1', 'data' => 10],
					    	['label' => 'Serie2', 'data' => 40],
					    	['label' => 'Serie3', 'data' => 20],
					    	['label' => 'Serie4', 'data' => 60],
					    	['label' => 'Serie5', 'data' => 10]
					    ],
					    'options' => [
							'series' => [
								'pie' => [
									'show' => true
								]
							]
					    ],
					    'htmlOptions' => [
					        'style' => 'width:100%;height:300px;'
					    ],
					]);
					?>
					</div>
				</div>
			</div>
			
		</div>
		
		
	</div>
	
	<div class="row">
		<div class="col-lg-12">
		</div>
	</div>	

</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_SIDEBAR') ?>
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_READY);
