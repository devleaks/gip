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

$asset = DashboardAsset::register($this);

// /@50.6231023,4.2940581
// EBLG: 50.63639, 5.44278
$liege = [
	'lat' => 50.63639,
	'lon' => 5.44278
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

		<!--
		  -- TOP LINE
		  --
		  --
		  --
		  -->
		<div class="row">

			<div class="col-lg-12">
				<div class="breakingNews" id="news" style="text-align: left;">
			    	<div class="bn-title"><h2>News For Liège Airport</h2><span></span></div>
			        <ul>
			        	<li><a href="#">Mauris interdum elit non sapien imperdiet, ac dapibus mi maximus</a></li>
			            <li><a href="#">Nullam sit amet nisl ex</a></li>
			            <li><a href="#">Cras lorem augue, facilisis a commodo in, facilisis finibus libero vel ultrices.</a></li>
			            <li><a href="#">Maecenas imperdiet ante vitae neque facilisis cursus</a></li>
			            <li><a href="#">Maecenas libero ipsum, placerat in mattis vel, tincidunt quis est.</a></li>
			            <li><a href="#">Curabitur tortor libero, vehicula sagittis luctus sed, lobortis sed arcu</a></li>
			        </ul>
			        <div class="bn-navi">
			        	<span></span>
			            <span></span>
			        </div>
			    </div>
			</div>

		</div>


		<div class="row">

		<!--
		  -- LEFT COLUMN
		  --
		  --
		  --
		  -->
		<div class="col-lg-2">
			<div class="row">
				<div class="col-lg-12">
					<div id="cssclock">
						<div id="clockanalog">
							<img src="<?=$asset->baseUrl?>/css/css-clocks/analogseconds.png" id="analogsecond" alt="Clock second-hand" />
							<img src="<?=$asset->baseUrl?>/css/css-clocks/analogminutes.png" id="analogminute" alt="Clock minute-hand" />
							<img src="<?=$asset->baseUrl?>/css/css-clocks/analoghours.png" id="analoghour"  alt="Clock hour-hand" />
						</div>
						<div id="clockdigital">
							<img src="<?=$asset->baseUrl?>/css/css-clocks/digitalhours.gif" id="digitalhour" alt="Clocks hours" />
							<img src="<?=$asset->baseUrl?>/css/css-clocks/digitalminutes.gif" id="digitalminute" alt="Clocks minutes" />
							<img src="<?=$asset->baseUrl?>/css/css-clocks/digitalseconds.gif" id="digitalsecond" alt="Clocks seconds" />
							<div>&nbsp;</div><div>&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
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
		  --
		  --
		  -->
		<div class="col-lg-8">

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
		  --
		  --
		  -->
		<div class="col-lg-2">
			
			<div class="row">
				<div class="col-lg-12">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'qfu',
						'color'		=> 'accent',
						'header'	=> 'DEPARTS',
						'footer'	=> 'L / R',
						'body'		=> '23',
						]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'qnh',
						'color'		=> 'info',
						'header'	=> 'ARRIVEES',
						'footer'	=> 'mBar',
						'body'		=> '1013',
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
					<?= Indicator::widget([
						'source'	=> 'aodb',
						'type'		=> 'dealy',
						'color'		=> 'warning',
						'header'	=> 'DELAY',
						'footer'	=> '%',
						'body'		=> '0',
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
		console.log('panel out');
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

    $("#news").breakingNews({
		effect		:"slide-v",
		autoplay	:true,
		timer		:3000,
		color		:"red"
	});
});


bDOMLoaded = true;
ClockInit();

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_READY);
?>
<script type="text/javascript">
<?php $this->beginBlock('JS_SIDEBAR') ?>
// this strange block of code exists to make sure the clocks are started as soon as
// possible as the page loads, rather than always waiting for a
// $(document).ready() as I normally do...
var bScriptLoaded       = false;
var bDOMLoaded          = false;
var bClocksInitialised  = false;

function ClockInit() {
    if ((bClocksInitialised != true) && (bDOMLoaded == true) && (bScriptLoaded == true)) {
        bClocksInitialised = true;
        oClockAnalog.fInit();
        oClockDigital.fInit();
    }
}
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_SIDEBAR'], yii\web\View::POS_BEGIN);
