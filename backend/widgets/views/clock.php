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
	<span class="gip-header"><?= $widget->title ?></span><br/>
	<span class="gip-body" data-gip="value"></span><br/>
	<span class="gip-footer" data-gip="note"></span>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	function show_clock(){
		var display = $(selector).find("[data-gip='note']").html() == 'U T C' ? moment.utc(new Date()).format('HH:mm:ss') : moment().format('HH:mm:ss');
		$(selector).find("[data-gip=value]").html( display );
	}
	/**
	 *	GIP Change Handler: Handle change messages
	 */
	$(selector).click(function() {
		if($(selector).find("[data-gip='note']").html() == 'U T C') {
			$(this).find("[data-gip='note']").html('LOCAL');
		} else {
			$(this).find("[data-gip='note']").html('U T C');
		}
		show_clock();
	});
	
	$(selector).addClass('gip-utc').find("[data-gip='note']").html('U T C');
	setInterval(show_clock,1000);
});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
