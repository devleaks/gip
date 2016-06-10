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

$parking = [
   	['color' => '#8f8', 'label' => 'Passenger Free', 'data' => round(50 * $widget->parking_data['pax']['avail'] / ($widget->parking_data['pax']['avail']+$widget->parking_data['pax']['busy']))],
   	['color' => '#f88', 'label' => 'Passenger Busy', 'data' => round(50 * $widget->parking_data['pax']['busy'] / ($widget->parking_data['pax']['avail']+$widget->parking_data['pax']['busy']))],
   	['color' => '#922', 'label' => 'Freit Busy', 'data' => round(50 * $widget->parking_data['freit']['busy'] / ($widget->parking_data['freit']['avail']+$widget->parking_data['freit']['busy']))],
   	['color' => '#292', 'label' => 'Freit Free', 'data' => round(50 * $widget->parking_data['freit']['avail'] / ($widget->parking_data['freit']['avail']+$widget->parking_data['freit']['busy']))]
];					
?>

<div id="<?= $widget_class ?>"
	 class="card gip-indicator style-bright"
>
<?= Chart::widget([
	'id' => 'gip-parking-pie',
    'data' => $parking,
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
			'color' => 'black'
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
<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>

_gip_parking_data = <?= json_encode($widget->parking_data) ?>;

jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	/**
	 *	GIP Message Handler: Handle plain messages (changes all parking)
	 */
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.parseJSON(msg.body);

		$.plot($('#gip-parking-pie'), [
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

		_gip_parking_data = payload;
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
