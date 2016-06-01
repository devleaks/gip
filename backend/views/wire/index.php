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

$liege = [
	'lat' => 50.63639,
	'lon' => 5.44278
];

$this->title = 'GIP - Live Wire';
?>
<div class="wire container-fluid">
	
	<main class="cd-main-content">

	<div class="row">

		<div class="col-lg-9">

			<div class="row">
				<div class="col-lg-12">
					<?php 

					// first lets setup the center of our map
					$center = new LatLng(['lat' => $liege['lat'], 'lng' => $liege['lon']]);

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
						'zoom' => 15
					]);
					// Different layers can be added to our map using the `addLayer` function.
					$leaflet->addLayer($marker)      // add the marker
					        ->addLayer($tileLayer);  // add the tile layer

					// finally render the widget
					echo Map::widget([
						'leafLet' => $leaflet,
						'height' => '900px',
					]);
					// we could also do
					// echo $leaflet->widget();
					?>

				</div>
			</div>

		</div>
	
		<div class="col-lg-3">

			<div class="row">
				<div class="col-lg-12">
				<a href="#0" class="cd-btn">GIP Alerts</a>
				</div>
			</div>

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
										'lat' => $liege['lat'],
										'lon' => $liege['lon'],
									]
								]);
							} else {
								Yii::$app->session->setFlash('error', 'Weather: No API key.');
							}
					?>
				</div>
			</div>
			
			<!--
			.card.style-accent
			.card.style-accent-bright
			.card.style-accent-dark
			.card.style-accent-light
			.card.style-danger
			.card.style-default
			.card.style-default-bright
			.card.style-default-dark
			.card.style-default-light
			.card.style-info
			.card.style-primary
			.card.style-primary-bright
			.card.style-primary-dark
			.card.style-primary-light
			.card.style-success
			.card.style-warning
			-->
			
			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-default-bright">
						QFU<br/><span style="font-size: 6em;">23</span><br/><span style="font-size: 2em;">L/R</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-primary">
						QNH<br/><span style="font-size: 6em;">1013</span><br/><span style="font-size: 2em;">mBar</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-success">
						AVG. DELAY<br/><span style="font-size: 6em;">12</span><br/><span style="font-size: 2em;">min</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-info">
						PARKING<br/><span style="font-size: 6em;">32</span><br/><span style="font-size: 2em;">%</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-warning">
						QFU<br/><span style="font-size: 6em;">23</span><br/><span style="font-size: 2em;">L/R</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-danger">
						QNH<br/><span style="font-size: 6em;">1013</span><br/><span style="font-size: 2em;">mBar</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-accent">
						QFU<br/><span style="font-size: 6em;">23</span><br/><span style="font-size: 2em;">L/R</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-default">
						QNH<br/><span style="font-size: 6em;">1013</span><br/><span style="font-size: 2em;">mBar</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<?php
						$data = [];
						$cur = round(rand(0, 100));
						for($i=0; $i<20; $i++) {
							$data[] = [$i, $cur];
							$cur += round(rand(-2, 2));
						}
					?>
					<?= Chart::widget([
					    'data' => [
					        [
					            'label' => 'Parking Space', 
					            'data'  => $data,
					            'lines'  => ['show' => true, 'steps' => true],
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
		
	</main>
	
	<div class="cd-panel from-right">
		<header class="cd-panel-header">
			<h1>GIP Alerts</h1>
			<a href="#0" class="cd-panel-close">Close</a>
		</header>

		<div class="cd-panel-container">
			<div class="cd-panel-content">
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
			</div> <!-- cd-panel-content -->
		</div> <!-- cd-panel-container -->
	</div> <!-- cd-panel -->

</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_SIDEBAR') ?>
jQuery(document).ready(function($){
	//open the lateral panel
	$('.cd-btn').on('click', function(event){
		event.preventDefault();
		$('.cd-panel').addClass('is-visible');
	});
	//clode the lateral panel
	$('.cd-panel').on('click', function(event){
		if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) { 
			$('.cd-panel').removeClass('is-visible');
			event.preventDefault();
		}
	});
});
parking_data = <?= json_encode($data) ?>;
function update_parking() {
	new_data = Array();
	diff2 = Array();
	len = parking_data.length - 1;
	for(var i=1;i<=len;i++) {
		new_data.push([i-1, parking_data[i][1]]);
	}
	diff = Math.round(Math.random()*4.5) - 2;
	diff2[diff + 2] = isNaN(diff2[diff + 2]) ? 1 : diff2[diff + 2]+1;
	console.log(diff2);
	new_data.push([len, parking_data[len][1] + diff]);
	$.plot($('#w1'), [{"label":"Parking Space","data":new_data,"lines":{"show":true, 'steps':true},"points":{"show":true}}], {"legend":{"position":"nw","show":true,"margin":10,"backgroundOpacity":0.5}});
	parking_data = new_data;
}
setInterval(update_parking, 5000);
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_READY);
