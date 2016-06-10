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
			$.plot($('#gip-movement'), [
				{"color":"#8f8","label":"PAX Free","data":payload['pax']['avail']},
				{"color":"#f88","label":"PAX Busy","data":payload['pax']['busy']},
				{"color":"#b00","label":"Freit Busy","data":payload['freit']['avail']},
				{"color":"#0b0","label":"Freit Free","data":payload['freit']['busy']}
			], {
				"series":{
					"pie":{
						"innerRadius":0.5,
						"show":true,
						"label":{
							"show":true,
							"radius":0.33333333333333,
							"threshold":0.1
						}
					}
				},
				"legend":{
					"show":false
				}
			});
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

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
