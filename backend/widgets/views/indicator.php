<?php
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
	 class="card card-bordered gip-indicator style-<?= $widget->color ?>"
>
	<span class="gip-header"><?= $widget->header ?></span><br/>
	<span class="gip-body" data-gip="value"><?= $widget->body ?></span><br/>
	<span class="gip-footer" data-gip="note"><?= $widget->footer ?></span>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$(selector).on('gip:message', function(event, msg) {
		var payload = $.parseJSON(msg.body);
		for (var property in payload) {
			$(this).find("[data-gip="+property+"]").html(payload[property]);
		}
		if(selector == '#gip-aodb-qfu') {
			$('#gip-gip-marker2-1').trigger(jQuery.Event( 'gip:change', { gip_payload: {note: payload['value'] + ' L'} } ));
			$('#gip-gip-marker2-2	').trigger(jQuery.Event( 'gip:change', { gip_payload: {note: payload['value'] + ' R'} } ));
		}
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
