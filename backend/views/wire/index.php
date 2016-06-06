<?php

use common\models\Wire as WireModel;

use backend\widgets\Wire;
use backend\widgets\Indicator;
use backend\widgets\Beacon;

//use backend\assets\WireAsset;
use backend\assets\DashboardAsset;

use devleaks\weather\Weather;

use bburim\flot\Chart;
use bburim\flot\Plugin;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

use yii\web\JsExpression;
use yii\bootstrap\Alert;

DashboardAsset::register($this);

// /@50.6231023,4.2940581
// EBLG: 50.63639, 5.44278
$liege = [
	'lat' => 50.6231023,
	'lon' => 4.2940581
];

$this->title = 'GIP - Live Wire';
/** card style colors
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
**/
?>
<div class="wire container-fluid">
	
	<main class="cd-main-content">

	<div class="row">

		<div class="col-lg-9">

			<div class="row">
				<div class="col-lg-12">
					<div class="card card-bordered style-default-bright">
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
						'height' => '600px',
					]);
					// we could also do
					// echo $leaflet->widget();
					?>
					</div>
				</div>
			</div>

		</div>
	
		<div class="col-lg-3">

			<div class="row">
				<div class="col-lg-12">
					<?php
						if(isset(Yii::$app->params['FORECAST_APIKEY'])) {
							echo '<div id="weather" class="card card-bordered style-default-bright "></div>';
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
							echo Alert::widget([
							    'options' => [
							        'class' => 'alert-info',
							    ],
							    'body' => Yii::t('gip', 'Weather Widget: No API key to fetch data.'),
							]);
						}
					?>

				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<?= Beacon::widget([
						'source'	=> 'gip',
						'type'		=> 'marker2',
						'channel'	=> 1,
						'color'		=> 'default-bright',
						'header'	=> 'INBOUND',
						'footer'	=> '23 L',
						]) ?>
				</div>
				<div class="col-lg-6">
					<?= Beacon::widget([
						'source'	=> 'gip',
						'type'		=> 'marker2',
						'channel'	=> 2,
						'color'		=> 'default-bright',
						'header'	=> 'INBOUND',
						'footer'	=> '23 R',
						]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'qfu',
						'color'		=> 'primary',
						'header'	=> 'QFU',
						'footer'	=> 'L / R',
						'body'		=> '23',
						]) ?>
				</div>
				<div class="col-lg-6">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'qnh',
						'color'		=> 'primary',
						'header'	=> 'QNH',
						'footer'	=> 'mBar',
						'body'		=> '1013',
						]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'delay',
						'color'		=> 'success',
						'header'	=> 'Avg. Delay (LAST 4H)',
						'footer'	=> 'minutes',
						'body'		=> '12',
						]) ?>
				</div>
				<div class="col-lg-6">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'forecast',
						'color'		=> 'accent',
						'header'	=> 'Forecast (NEXT 4H)',
						'footer'	=> 'minutes',
						'body'		=> '4',
						]) ?>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'parking',
						'color'		=> 'warning',
						'header'	=> 'PARKING',
						'footer'	=> '%',
						'body'		=> '0',
						]) ?>
				</div>
				<div class="col-lg-6">
						<?= Indicator::widget([
							'source'	=> 'gip',
							'type'		=> 'alert',
							'color'		=> 'danger',
							'header'	=> 'GIP',
							'footer'	=> 'Alerts',
							'body'		=> '0',
							]) ?>
					</div>
				</div>
			</div>

			<div class="row">
				<!--div class="col-lg-6">
					<div class="card card-bordered style-default gip-indicator">
						<span class="gip-header">COLORS</span><br/>
						<span class="gip-body">7</span><br/>
						<span class="gip-footer">+ 9 VARIANTS</span>
					</div>
				</div -->
				
				<div class="col-lg-12">				
					<div class="card card-bordered style-default-bright">
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
				
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="card card-bordered style-default-bright">
					<?php
						$parking_max = 75;
						$parking_data = [];
						$cur_parking = round(rand($parking_max / 10, $parking_max / 2));
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
		
		
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-bordered style-default-bright">
				<?php
				$data = [];
				$count = 4; // hours
				$divs  = 12; // 5 mins, divs per hour.
				$delta = 3600000 / $divs; // milli secs
				$start = time() * 1000 - ($count * 3600000);
				for($i = 0; $i< (2*$count*$divs); $i++) {
					$data[] = [$start + $i * $delta, round(rand(-2, 3))];
				}
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
							'timezone' => 'browser',
							'minTickSize' => [15, "minute"],
							'timeformat' => "%H:%M",/*https://github.com/flot/flot/blob/master/API.md*/
						]
				    ],
				    'htmlOptions' => [
				        'style' => 'width:100%;height:100px;'
				    ]
				]);
				?>
			</div>
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
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_READY);
?>
<script type="text/javascript">
<?php $this->beginBlock('JS_PARKING') ?>
parking_data = <?= json_encode($parking_data) ?>;
parking_max = <?= $parking_max ?>;

function update_parking() {
	new_data = Array();
	for(var i=1;i<parking_data.length;i++) {
		new_data.push([i-1, parking_data[i][1]]);
	}
	diff = Math.floor(Math.random()*5) - 2;
	new_val = parking_data[parking_data.length - 1][1] + diff;
	if(new_val > parking_max) new_val = parking_max;
	new_data.push([parking_data.length - 1, new_val]);
	
	jQuery(document).ready(function($){
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

		$('#aodb-parking').html(Math.round(100 * new_val / parking_max));
	
	});

	parking_data = new_data;
}
setInterval(update_parking, 10000);
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_PARKING'], yii\web\View::POS_READY);
