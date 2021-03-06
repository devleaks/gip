<?php
$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
if($widget->channel) {
	$widget_class .= strtolower('-'.$widget->channel);
	$widget_hndlr .= strtoupper('_'.$widget->channel);
}
?>

<div id="<?= $widget_class ?>"
	 class="card card-bordered gip-indicator markers style-<?= $widget->color ?>"

	<span class="gip-header"><?= $widget->header ?></span><br/>
	<span class="gip-body">
		<a class="marker marker-inner">I</a>
		<a class="marker marker-middle">M</a>
		<a class="marker marker-outer">O</a>
	</span><br/>
	<span class="gip-footer" data-gip="note"><?= $widget->footer ?></span>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>
jQuery(document).ready(function($){

	var opts = {
		marker_beacons: {
			inner: {
				count: 12,
				speed: 'fast'
			},
			middle: {
				count: 7,
				speed: 'medium'
			},
			outer: {
				count: 5,
				speed: 'slow'
			}
		},
		soundFileLocation: '/gipadmin/assets/bcd26606/snd/'
	};

	function blink(selector, marker, count) {
		if(count > opts.marker_beacons[marker]['count']) return;
		$(selector).fadeOut(opts.marker_beacons[marker]['speed'], function(){
		    $(this).fadeIn(opts.marker_beacons[marker]['speed'], function(){
		        blink(this, marker, count + 1);
		    });
		});
	}

	function play_sound(marker) {
		var audio = new Audio();
        audio.src = opts.soundFileLocation + marker + '.mp3';;
        audio.play();
	}
	
	function get_marker(msg, payload) {
		var lid = msg.source+'-'+msg.type;
		if(typeof msg.channel !== undefined) {
			lid += ('-'+msg.channel);			
		}
		return ("#gip-"+lid).toLowerCase();
	}
	
	var selector = "#" + "<?= $widget_class ?>";

	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.dashboard.get_payload(msg);
		var mid = get_marker(msg, payload);
		play_sound(payload.marker);
		blink(mid+" a.marker-"+payload.marker, payload.marker, 0);
	});

	/**
	 *	GIP Change Handler: Handle change messages
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
