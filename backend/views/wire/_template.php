<?php

$giplet_source	= "aodb";
$giplet_type	= "qfu";

$giplet_class 	= strtolower('gip-'.$giplet_source.'-'.$giplet_type);
$giplet_hndlr 	= strtoupper($giplet_source.'_'.$giplet_type);

/**
	var event = jQuery.Event( "logged" );
	event.user = "foo";
	event.pass = "bar";
	$( "body" ).trigger( event );

	Alternative way to pass data through an event object:
	$( "body" ).trigger({
	  type:"logged",
	  user:"foo",
	  pass:"bar"
	});
	
	$( "body" ).on("logged", function(event) {
		user = event.user;
		pass = event.pass;
	});
 **/
?>

<div id="<?= $giplet_class ?>"
	 class="card card-bordered style-info gip-indicator"
>
	<span class="gip-header">QFU</span><br/>
	<span class="gip-body" data-gip="value">23</span><br/>
	<span class="gip-footer" data-gip="note">L / R</span>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$giplet_hndlr) ?>
jQuery(document).ready(function($){

	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$("#" + "<?= $giplet_class ?>").on('gip:message', function(event, msg) {
		var payload = $.parseJSON(msg.body);
		for (var property in payload) {
			$(this).find("[data-gip="+property+"]").html(payload[property]);
		}
	});

	/**
	 *	GIP Change Handler: Handle change messages
	 */
	$("#" + "<?= $giplet_class ?>").on('gip:change', function(event) {
		var payload = event.gip_payload;
		for (var property in payload) {
			$(this).find("[data-gip="+property+"]").html(payload[property]);
		}
	});

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$giplet_hndlr], yii\web\View::POS_READY);
