<?php

use common\models\Wire as WireModel;

use backend\widgets\Beacon;
use backend\widgets\Clock;
use backend\widgets\DelayTable;
use backend\widgets\FlightTable;
use backend\widgets\Indicator;
use backend\widgets\Metar;
use backend\widgets\Movement;
use backend\widgets\News;
use backend\widgets\Parking;
use backend\widgets\Wire;

//use backend\assets\WireAsset;
use backend\assets\DashboardAsset;

use devleaks\weather\Weather;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

use yii\web\JsExpression;
use yii\bootstrap\Alert;
use yii\helpers\Html;

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
						'title' => '<i class="fa fa-warning"></i> Important',
						'news' => [
							'Mercredi 22 — Demo Geo Intelligent Platform',
					        'Welcome Oscars — Good luck with your demo',
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
			
			
			<div class="row">
				<div class="col-lg-12">
					<div class="card card-bordered style-default-bright ">
						<img src="<?= $asset->baseUrl.'/images/gip-comm.png' ?>" width="100%">
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
					<div class="card card-bordered style-default-bright">
					<?= $this->render('_mapj', [
							'center' => $liege,
							'zoom' => (rand(0, 1) == 1 ? 8 : 15), //15=close, 8=about 150km around
							'height' => 900,
						]) ?> 
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
					<div class="card card-bordered style-default-bright ">
						<img src="<?= $asset->baseUrl.'/images/liege.png' ?>" width="100%" style="padding: 4px;">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<?= Movement::widget([
						'source'	=> 'aodb',
						'type'		=> 'movements',
						'title'	=> 'MOVEMENTS',
						'movements' => []
					]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?= FlightTable::widget([
						'source'	=> 'aodb',
						'type'		=> 'departure',
						'title'	=> 'DEPARTURE',
						'flights' => [ [
								'registration' => 'EBLG',
								'flight_number' => 'EBLG',
								'airport' => 'Liège',
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
								'airport' => 'Liège',
								'schedule' => '00:00',
								'estimated' => '00:00',
								'actual' => '-',
								'delay' => '0'
							],
							[
									'registration' => 'EBLG1',
									'flight_number' => 'EBLG1',
									'airport' => 'Liège',
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
					<?= Parking::widget([
						'source'	=> 'aodb',
						'type'		=> 'parking-occupancy',
						'title'	=> 'PARKING',
						'parking_data' => [
							'pax' => ['busy' => 10, 'avail' => 12],
							'freit' => ['busy' => 7, 'avail' => 16],
						],
					]) ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<?= DelayTable::widget([
						'source'	=> 'aodb',
						'type'		=> 'delay-report',
						'title'	=> 'DELAYS',
						'delays' => [
							[ 'code' => '01', 'reason' => 'Weather', 'time' => '7870', 'percent' => '44 %'],
						],
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
			<h1><img src="<?= $asset->baseUrl.'/images/gip.png' ?>" height="40px" style="padding-right: 20px;">GIP ALERTS</h1>
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
	$.dashboard.init({websocket: "<?= Yii::$app->params['websocket_server'] ?>", debug: false, max_priority: 6});

	$.dashboard.set_time(new Date('2016-04-07T21:40:00'));
	
	$('#gip-aodb-movements').trigger('click');
	$('#gip-aodb-arrival').trigger('click');
	$('#gip-aodb-departure').trigger('click');
	$('#gip-aodb-parking-occupancy').trigger('click');
	$('#gip-aodb-delay-report').trigger('click');
	
	//open the lateral panel
	$('.cd-btn').on('click', function(event){
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
