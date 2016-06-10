<?php
use frontend\assets\MetarAsset;

use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var \yii\bootstrap\Widget $widget
 */
MetarAsset::register($this);

$widget_class 	= strtolower('gip-'.$widget->source.'-'.$widget->type);
$widget_hndlr 	= strtoupper($widget->source.'_'.$widget->type);
?>

<div id="<?= $widget_class ?>"
	 class="card card-bordered gip-indicator style-info metar"
>
	<span class="gip-header">METAR</span><br/>
	<div class="gip-body" data-gip="value"></div><br/>
	<span class="gip-footer" data-gip="note">LAST UPDATED</span>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_UPDATEMETAR') ?>
function init_metar() {
	giplet = $('.metar');
	$.get(
		"wire/get-metar",
		function (r) {
			s = JSON.parse(r);
			//console.log(s);
			if(s.e != null) {
				giplet.find('.gip-body').html(s.errors);
				giplet.find('.gip-footer').html(new Date());
			} else {
				t = s.metar;
				//console.log(t);
				u = metar_decode(t);
				//console.log(u);
				str = u.replace(/(?:\r\n|\r|\n)/g, '<br/>');
				giplet.find('.gip-body').html(str);
				giplet.find('.gip-footer').html('LAST UPDATED ' + moment().format('HH:mm')+ ' L');
			}
	    }
	);
};
init_metar();
setInterval(init_metar, 10 * 60000); /* 10 minutes in msecs */
jQuery(document).ready(function($){
	var selector = "#" + "<?= $widget_class ?>";
	/**
	 *	GIP Message Handler: Handle plain messages
	 */
	$(selector).on('gip:message', function(event, msg) {
		t = msg.body;
		//console.log(t);
		u = metar_decode(t);
		//console.log(u);
		str = u.replace(/(?:\r\n|\r|\n)/g, '<br/>');
		$(this).find('.gip-body').html(str);
		$.dashboard.last_updated(msg, $(this));
		//$(this).find('.gip-footer').html('LAST UPDATED ' + moment().format('HH:mm')+ ' L');
	});

});
<?php $this->endBlock(); ?>
</script>

<?php
$this->registerJs($this->blocks['JS_UPDATEMETAR'], yii\web\View::POS_READY);
