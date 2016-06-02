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

use yii\web\JsExpression;

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
			
			<!-- card style colors
			.style-accent
			.style-accent-bright
			.style-accent-dark
			.style-accent-light

			.style-default
			.style-default-bright
			.style-default-dark
			.style-default-light

			.style-primary
			.style-primary-bright
			.style-primary-dark
			.style-primary-light

			.style-danger
			.style-info
			.style-success
			.style-warning
			-->
						
			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-default-bright gip-indicator markers">
						<span class="gip-header">INBOUND</span><br/>
						<span class="gip-body">
						<a class="marker marker-inner marker-left">I</a>
						<a class="marker marker-middle marker-left">M</a>
						<a class="marker marker-outer marker-left">O</a></span><br/>
						<span class="gip-footer">23 L</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-default-bright gip-indicator markers">
						<span class="gip-header">INBOUND</span><br/>
						<span class="gip-body">
						<a class="marker marker-inner marker-right">I</a>
						<a class="marker marker-middle marker-right">M</a>
						<a class="marker marker-outer marker-right">O</a></span><br/>
						<span class="gip-footer">23 R</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-info gip-indicator">
						<span class="gip-header">QFU</span><br/>
						<span class="gip-body" id="aodb-qfu-value">23</span><br/>
						<span class="gip-footer" id="aodb-qfu-note">L / R</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-primary gip-indicator">
						<span class="gip-header">QNH</span><br/>
						<span class="gip-body">1013</span><br/>
						<span class="gip-footer">mBar</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-success gip-indicator">
						<span class="gip-header">Avg. Delay (LAST 4H)</span><br/>
						<span class="gip-body">12</span><br/>
						<span class="gip-footer">minutes</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-accent gip-indicator">
						<span class="gip-header">Forecast (NEXT 4H)</span><br/>
						<span class="gip-body">4</span><i class="fa fa-arrow-down"></i><br/>
						<span class="gip-footer">minutes</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-warning gip-indicator">
						<span class="gip-header">PARKING</span><br/>
						<span class="gip-body" id="aodb-parking">0</span><br/>
						<span class="gip-footer">%</span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-bordered style-danger  gip-indicator cd-btn">
						<span class="gip-header">GIP</span><br/>
						<span class="gip-body" id="gip-alerts">0</span><br/>
						<span class="gip-footer">Alerts</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<div class="card card-bordered style-default gip-indicator">
						<span class="gip-header">COLORS</span><br/>
						<span class="gip-body">7</span><br/>
						<span class="gip-footer">+ 9 VARIANTS</span>
					</div>
				</div>
				
				<div class="col-lg-6">				
				<?php
				$moves = [
					'in' => ['L' => 12, 'R' => 4],
					'out' => ['L' => 9, 'R' => 7],
				];
				
				echo Chart::widget([
					'id' => 'inout-graph',
				    'data' => [
				    	['label' => 'Inbound L', 'data' => round(50 * $moves['in']['L'] / ($moves['in']['L']+$moves['in']['R']))],
				    	['label' => 'Inbound R', 'data' => round(50 * $moves['in']['R'] / ($moves['in']['L']+$moves['in']['R']))],
				    	['label' => 'Outbound L', 'data' => round(50 * $moves['out']['L'] / ($moves['out']['L']+$moves['out']['R']))],
				    	['label' => 'Outbound R', 'data' => round(50 * $moves['out']['R'] / ($moves['out']['L']+$moves['out']['R']))]
				    ],
				    'options' => [
						'series' => [
							'pie' => [
								'innerRadius' => 0.5,
								'show' => true,
								'label' => [
					                'show' => true,
					                'radius' => 1/3,
					                // 'formatter' => new JsExpression("labelFormatter"),
					                'threshold' => 0.1
						          ]
							],
						],
				        'legend' => [
				            'show'              => false,
				        ],
				    ],
				    'htmlOptions' => [
				        'style' => 'width:100%;height:200px;'
				    ],
				    'plugins' => [
				        Plugin::PIE,
						Plugin::TIME
				    ]
				]);
				?>
				</div>
				
			</div>

			<div class="row">
				<div class="col-lg-12">
					<?php
						$max_parking = 75;
						$parking_data = [];
						$cur_parking = round(rand($max_parking / 10, $max_parking / 2));
						for($i=0; $i<20; $i++) {
							$parking_data[] = [$i, $cur_parking];
							$cur_parking += round(rand(-2, 3));
						}
					echo Chart::widget([
						'id' => 'parking-graph',
					    'data' => [
					        [
					            'label' => 'Parking Space', 
					            'data'  => $parking_data,
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
					        'style' => 'width:100%;height:200px;'
					    ],
					]);
					?>
				</div>
			</div>
			
			
		</div>
		
		
	</div>
	
	<div class="row">
		<div class="col-lg-12">
				<?php
				$data = [];
				$count = 4; // hours
				$divs  = 12; // 5 mins.
				$delta = 3600000 / $divs; // milli secs
				$start = time();
				//echo date('d-m-y h:i:s', $start);
				for($i = 0; $i< (2*$count*$divs); $i++) {
					$data[] = [$start + $i * $delta, round(rand(-2, 3))];
				}
				//echo print_r($data, true);
				
				echo Chart::widget([
					'id' => 'graph-time',
				    'data' => [
				        [
				            'label' => 'Movements', 
				            'data'  => $data,
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
						'xaxis' => [
							'mode' => 'time',
							'timezone' => 'Europe/Brussels',
							'minTickSize' => [15, "minute"],
							'timeformat' => "%d %H:%M",
//			                'min' => strtotime("-4 hours"),
//			                'max' => strtotime("+4 hours")
						]
				    ],
				    'htmlOptions' => [
				        'style' => 'width:100%;height:100px;'
				    ]
				]);
				/*
			 %h: hours
			  %H: hours (left-padded with a zero)
			  %M: minutes (left-padded with a zero)
			  %S: seconds (left-padded with a zero)
			  %d: day of month (1-31), use %0d for zero-padding
			  %m: month (1-12), use %0m for zero-padding
			  %y: year (2 digits)
			  %Y: year (4 digits)
			  %b: month name (customizable)
			  %p: am/pm, additionally switches %h/%H to 12 hour instead of 24
			  %P: AM/PM (uppercase version of %p)				*/
				?>
		</div>
	</div>	
		
	</main>
	
	<div class="cd-panel from-right">
		<header class="cd-panel-header">
			<h1>GIP ALERTS</h1>
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
parking_data = <?= json_encode($parking_data) ?>;
function update_parking() {
	max_parking = <?= $max_parking ?>;
	new_data = Array();
	for(var i=1;i<parking_data.length;i++) {
		new_data.push([i-1, parking_data[i][1]]);
	}
	diff = Math.floor(Math.random()*5) - 2;
	new_val = parking_data[parking_data.length - 1][1] + diff;
	if(new_val > max_parking) new_val = max_parking;
	new_data.push([parking_data.length - 1, new_val]);
	
	$('#aodb-parking').html(Math.round(100 * new_val / max_parking));
	
	$.plot($('#parking-graph'),
		[{
			"label":"Parking Space",
			"data":new_data,
			"lines": {
				"show":true,
				'steps':true
			},
			"points": {
				"show":true
			}
		}], {
			"legend": {
				"position":"nw",
				"show":true,
				"margin":10,
				"backgroundOpacity":0.5
			}
		}
	);
	parking_data = new_data;
}
setInterval(update_parking, 10000);
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_READY);
