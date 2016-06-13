<?php
use bburim\flot\Chart;
use bburim\flot\Plugin;

/**
 *
 *	var event = jQuery.Event( "logged" );
 *	event.user = "foo";
 *	event.pass = "bar";
 *	$( "body" ).trigger( event );
 *
 *	Alternative way to pass data through an event object:
 *	$( "body" ).trigger({
 *	  type:"logged",
 *	  user:"foo",
 *	  pass:"bar"
 *	});
 *	
 *	$( "body" ).on("logged", function(event) {
 *		user = event.user;
 *		pass = event.pass;
 *	});
 **/
$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
$a = [
    [1,2],
    [2,-2],
    [3,3],
    [4,0],
    [5,1],
    [6,-2],
    [7,-2],
    [8,3],
    [9,0],
    [10,-1],
    [11,2],
    [12,-2],
    [13,-3],
    [14,0],
    [15,1],
];
$hour = 3600000;
$step = count($a) > 1? round(8 * $hour / (count($a)-1)) : 1800000; // default 1/2 hour
$offs = time() * 1000 - (4 * $hour);
$b = [];
foreach($a as $i => $e) { // starts 4 hours ago, display next four hours
	$a[$i][0] = $offs + $a[$i][0] * $step;
	$b[] = $a[$i][1] < 0 ? [$a[$i][0], $a[$i][1]] : [$a[$i][0], 0];
	$a[$i][1] = $a[$i][1] >= 0 ? $a[$i][1] : 0;
}
?>

<div id="<?= $widget_class ?>"
	 class="card gip-indicator style-bright"
>
	<span class="gip-header">MOVEMENTS</span><br/>
<?= Chart::widget([
	'id' => 'gip-movement',
    'data' => [
	        [
	            'label' => 'departure', 
	            'data'  => $a,
	        ],
	        [
	            'label' => 'arrival', 
	            'data'  => $b,
	        ],
	    ],
    'options' => [
		'series' => [
			'bars' => [
				'show' => true
			],
		],
		'xaxis' => [
			'mode' => 'time',
			'timezone' => 'browser',
			'minTickSize' => [15, "minute"],
			'timeformat' => "%d %H:%M",
//                'min' => strtotime("-4 hours"),
//                'max' => strtotime("+4 hours")
		],
		'colors' => ['#f00', '#0f0']
   ],
    'htmlOptions' => [
        'style' => 'width:100%;height:200px;'
    ],
    'plugins' => [
		Plugin::PIE,
		Plugin::STACK,
		Plugin::TIME
    ]
]);
?>
	<span class="gip-footer" data-gip="note">LAST UPDATED</span>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>

jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";

	$(selector).on('gip:message', function(event, msg) {
		var payload = $.dashboard.get_payload(msg);
		
		if(payload) {
			$.plot($('#gip-movement'), [], {});
		}
	});

	/**
	 *	GIP Change Handler: Handle only +1 parking
	 */
	$(selector).on('gip:change', function(event) {
		var payload = event.gip_payload;
		for (var property in payload) {
			$(this).find("[data-gip="+property+"]").html(payload[property]);
		}
	});
	
	$(selector).click(function() {
		$.dashboard.set_time(new Date('2016-04-03T10:00:00'));
		delayed_time = moment($.dashboard.get_time());
		
		// get scheduled flights (all positive numbers)
		$.post(
			"wire/get-movements",
			{
				'around': delayed_time.format('YYYY-MM-DD HH:mm')
			},
			function (r) {
				var s = JSON.parse(r);
				//console.log(s);

				var sched_arr = new Array(), sched_dep = new Array();
				var work = s.sched;
				for(var i = 0; i < work.length; i++) {
					if(work[i].dir == 'A') {
						sched_arr.push([work[i].sched * 1000, work[i].count]);
					} else {
						sched_dep.push([work[i].sched * 1000, work[i].count]);
					}
				}
				//console.log(sched_arr);

				var plan_arr = new Array(), plan_dep = new Array();
				work = s.plan;
				//console.log(sched);
				for(var i = 0; i < work.length; i++) {
					if(work[i].dir == 'A') {
						plan_arr.push([work[i].planned * 1000, -work[i].count]);
					} else {
						plan_dep.push([work[i].planned * 1000, -work[i].count]);
					}
				}
				//console.log(plan_arr);

				var act_arr = new Array(), act_dep = new Array();
				work = s.act;
				//console.log(sched);
				for(var i = 0; i < work.length; i++) {
					if(work[i].dir == 'A') {
						act_arr.push([work[i].actual * 1000, -work[i].count]);
					} else {
						act_dep.push([work[i].actual * 1000, -work[i].count]);
					}
				}
				//console.log(act_arr);

				$.plot($('#gip-movement'),
					[
						{
						    stack: true,
							label: 'sched dep',
						    data: sched_dep,
						    color: "#f00"
						},{
						    stack: true,
							label: 'sched arr',
						    data: sched_arr,
						    color: "#0f0"
						},{
						    stack: true,
							label: 'act dep',
						    data: act_dep,
						    color: "#800"
						},{
						    stack: true,
							label: 'act arr',
						    data: act_arr,
						    color: "#080"
						},{
						    stack: true,
							label: 'plan dep',
						    data: plan_dep,
						    color: "#f88"
						},{
						    stack: true,
							label: 'plan arr',
						    data: plan_arr,
						    color: "#8f8"
						}
					],
					{
				        series: {
							stack: true,
				            lines: {show: false, steps: false},
				            bars: {show: true, barWidth: 0.4, align: 'center'}
				        },
				        xaxis: {
							mode: 'time',
							timezone: 'browser'
				        },
				        legend: {
				            show: true
				        }
					}
				);
		    }
		);
	});
	
	// $(selector).trigger('click');

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
