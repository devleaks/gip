<?php

use frontend\assets\RandomChartAsset;

use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;

use yii\web\JsExpression;

HighchartsAsset::register($this);
RandomChartAsset::register($this);

?>
<div class="highcharts-widget">
	
	<?= Highcharts::widget([
		'setupOptions' => [
			'global' => [
				'useUTC' => false
			]
		],
		'options' => [
				'title' => [ 'text' => 'Real Time Samples' ],
				'xAxis' => [
					'type' => 'datetime',
					'tickPixelInterval' => 100
				],
				'yAxis' => [
					'title' => [ 'text' => 'Samples' ],
					'tickInterval' => 10,
					'min' => 0,
					'max' => 100
				],
				'tooltip' => [
		            'formatter' => new JsExpression("function() {
		                return '<b>'+ this.series.name + '</b><br/>'
		                    + '[ ' + Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x)
		                    + ' , '
		                    + this.y + ' ]';
		            }")
				],
				'chart' => [
					'type' => 'spline',
					'events' => [
						'load' => new JsExpression("function() {
							var series = this.series[0];
						    var socket = io.connect('http://imac.local:3131');
						    socket.on('sample', function (sample) {
						    	// when a sample arrives we plot it
								series.addPoint([sample.x, sample.y], true, true);
						    });
						}")
					]
				],
		        'series' => [[
		            'name' => 'Random data',
		            'data' => new JsExpression("(function() {
		                // generate some points to render before real samples arrive from feed
		                var data = [],
		                    time = (new Date()).getTime(),
		                    i;
		                // 20 samples, starting 19 ms ago up to present time when feed starts plotting
		                for (i = -19; i <= 0; i++) {
		                    data.push({
		                        x: time + (i * 1000),
		                        y: Math.floor((Math.random() * 100) + 1)
		                    });
		                }
		                return data;
		            })()")
		        ]]
			]
		]);?>

</div>
