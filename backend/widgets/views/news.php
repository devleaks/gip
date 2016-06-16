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
     class="breakingNews" style="text-align: left;">
	<div class="bn-title"><h2><?= $widget->title ?></h2><span></span></div>
    <ul>
		<?php
		foreach($widget->news as $news) {
			echo '<li>'.$news.'</li>';
		}
		?>
    </ul>
    <div class="bn-navi">
    	<span></span>
        <span></span>
    </div>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_GIP_'+$widget_hndlr) ?>
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	var current_news = 0;
	var count_news = $(selector+' ul li').length;

	/**
	 *	GIP Message Handler: Handle plain messages
	 */
    $(selector).breakingNews({
		effect		:"slide-v",
		autoplay	:true,
		timer		:3000,
		color		:"red"
	});

	$(selector).on('gip:message', function(event, msg) {
		$(selector+' ul').find('li:nth-child('+(current_news % count_news + 1)+')').html(msg.body);
	});

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GIP_'+$widget_hndlr], yii\web\View::POS_READY);
