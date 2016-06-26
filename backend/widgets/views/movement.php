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
?>
<div id="<?= $widget_class ?>"
	 class="card gip-indicator style-bright"
>
	<span class="gip-header">MOVEMENTS</span><br/>
	<div id="gip-movement" style="width:100%;height:200px;"></div>
	<span class="gip-footer" data-gip="note">LAST UPDATED</span>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>

jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";

	/**
	 *	GIP Message Handler
	 */
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.dashboard.get_payload(msg);
		
		if(payload) {
			$.plot($('#gip-movement'), [], {});
		}
	});

	/**
	 *	GIP Change Handler
	 */
	$(selector).on('gip:change', function(event) {
		//$(selector).trigger('click');
	});
	
	$(selector).click(function() {
		delayed_time = moment($.dashboard.get_time());
		
		// get scheduled flights (all positive numbers)
		$.post(
			"wire/get-movements",
			{
				'around': delayed_time.utc().format('YYYY-MM-DD HH:mm')
			},
			function (r) {
				//console.log(selector, delayed_time.utc().format('YYYY-MM-DD HH:mm'), r);
				var s = JSON.parse(r);

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
				            show: false
				        }
					}
				);
		    }
		);
		
		$.dashboard.big_tick();
	});
	
	$(selector).trigger('click');

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
