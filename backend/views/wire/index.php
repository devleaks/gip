<?php

use common\models\Wire as WireModel;

use backend\widgets\Beacon;
use backend\widgets\Clock;
use backend\widgets\FlightTable;
use backend\widgets\Indicator;
use backend\widgets\Metar;
use backend\widgets\News;
use backend\widgets\Wire;

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

$asset = DashboardAsset::register($this);

// /@50.6231023,4.2940581
// EBLG: 50.63639, 5.44278
$liege = [
	'lat' => 50.63639,
	'lon' => 5.44278
];

$this->title = 'GIP Dashboard';
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

		<!--
		  -- TOP LINE
		  --
		  -->
		<div class="row">

			<div class="col-lg-12">
				<?= News::widget([
						'source' => 'gip',
						'type'	=> 'news',
						'title' => 'News For Liège Airport',
						'news' => [
							'Mauris interdum elit non sapien imperdiet, ac dapibus mi maximus',
					        'Nullam sit amet nisl ex',
					        'Cras lorem augue, facilisis a commodo in, facilisis finibus libero vel ultrices.',
					        'Maecenas libero ipsum, placerat in mattis vel, tincidunt quis est.',
					        'Curabitur tortor libero, vehicula sagittis luctus sed, lobortis sed arcu',
						]
					]);
				?>
			</div>

		</div>


		<div class="row">

		<!--
		  -- LEFT COLUMN
		  --
		  -->
		<div class="col-lg-2">
			<div class="row">
				<div class="col-lg-12">
					<?= Clock::widget([
						'source' => 'gip',
						'type' => 'clock',
						'color' => 'default-bright',
						'title' => 'Liège Airport'
					]) ?>
				</div>
			</div>
			<!--div class="row">
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
			</div -->
			<div class="row">
				<div class="col-lg-12">
					<?= Metar::widget([
							'source' => 'gip',
							'type' => 'metar',
							'location' => 'EBLG'
						]);
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'qfu',
						'color'		=> 'primary',
						'header'	=> 'QFU',
						'footer'	=> 'L / R',
						'body'		=> '23',
						]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="cd-btn">
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

			
			
		</div><!-- end left column -->

		<!--
		  -- MAP
		  --
		  -->
		<div class="col-lg-8">

			<div class="row">
				<div class="col-lg-12">
					<!-- iframe id="flight-radar" src="http://www.flightradar24.com/simple_index.php?lat=50.63639&amp;lon=5.44278&amp;z=9&amp;airports=1" width="100%" height="800"></iframe -->
					
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
						'zoom' => (rand(0, 1) == 1 ? 8 : 15) //15=close, 8=about 150km around
					]);
					// Different layers can be added to our map using the `addLayer` function.
					$leaflet->addLayer($marker)      // add the marker
					        ->addLayer($tileLayer);  // add the tile layer

					// finally render the widget
					echo Map::widget([
						'leafLet' => $leaflet,
						'height' => '900',
					]);
					// we could also do
					// echo $leaflet->widget();
					?>
					</div>
				</div>
			</div>

		</div><!-- end map -->
	
		<!--
		  -- RIGHT COLUMN
		  --
		  -->
		<div class="col-lg-2">
			
			<div class="row">
				<div class="col-lg-12">
					<?= FlightTable::widget([
						'source'	=> 'aodb',
						'type'		=> 'departure',
						'title'	=> 'DEPARTURE',
						'flights' => [ [
								'registration' => 'EBLG',
								'flight_number' => 'EBLG',
								'destination' => 'Liège',
								'schedule' => '00:00',
								'estimated' => '00:00',
								'actual' => '-',
								'delay' => '0'
							]
						]
					]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?= FlightTable::widget([
						'source'	=> 'aodb',
						'type'		=> 'arrival',
						'title'	=> 'ARRIVAL',
						'flights' => [ [
								'registration' => 'EBLG',
								'flight_number' => 'EBLG',
								'destination' => 'Liège',
								'schedule' => '00:00',
								'estimated' => '00:00',
								'actual' => '-',
								'delay' => '0'
							],
							[
									'registration' => 'EBLG1',
									'flight_number' => 'EBLG1',
									'destination' => 'Liège',
									'schedule' => '00:00',
									'estimated' => '00:00',
									'actual' => '-',
									'delay' => '0'
							]
						]
					]) ?>
				</div>
			</div>
			
			<div class="row">
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
					    	['label' => 'Passenger Free', 'data' => round(50 * $moves['in']['L'] / ($moves['in']['L']+$moves['in']['R']))],
					    	['label' => 'Passenger Busy', 'data' => round(50 * $moves['in']['R'] / ($moves['in']['L']+$moves['in']['R']))],
					    	['label' => 'Freit Busy', 'data' => round(50 * $moves['out']['R'] / ($moves['out']['L']+$moves['out']['R']))],
					    	['label' => 'Freit Free', 'data' => round(50 * $moves['out']['L'] / ($moves['out']['L']+$moves['out']['R']))],
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
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'dealy',
						'color'		=> 'warning',
						'header'	=> 'DELAY',
						'footer'	=> 'min',
						'body'		=> '12',
						]) ?>
				</div>
			</div>
						
			<div class="row">
				<div class="col-lg-12">
					<?= Beacon::widget([
						'source'	=> 'gip',
						'type'		=> 'marker2',
						'channel'	=> 1,
						'color'		=> 'default-bright',
						'header'	=> 'INBOUND',
						'footer'	=> '23 L',
						]) ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
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
			
		</div><!-- end right column -->
		
		
	</div>
	
	</main>
	
	<!--
	  -- SIDE PANEL
	  --
	  -->
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
							'source' => 'gip',
							'type' => 'wire',
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
<?php $this->beginBlock('JS_DASHBOARD') ?>
jQuery(document).ready(function($){
	//main communication
	$.dashboard.init({websocket: "<?= Yii::$app->params['websocket_server'] ?>"});
	
	//open the lateral panel
	$('.cd-btn').on('click', function(event){
		console.log('panel out');
		event.preventDefault();
		$('.cd-panel').addClass('is-visible');
	});
	//close the lateral panel
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
$this->registerJs($this->blocks['JS_DASHBOARD'], yii\web\View::POS_READY);
