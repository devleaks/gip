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
	var giplet = $('.metar');
	$.get(
		"wire/get-metar-live",
		function (r) {
			//console.log(r);
			var ret = JSON.parse(r);
			if(ret.e != null) {
				giplet.find('.gip-body').html(s.errors);
				giplet.find('.gip-footer').html(new Date());
			} else {
				var metar = ret.metar;
				//console.log(metar);
				var decoded_metar = metar_decode(metar);
				//console.log(decoded_metar);
				var str = decoded_metar.replace(/(?:\r\n|\r|\n)/g, '<br/>');
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
		var payload = $.dashboard.get_payload(msg);
		var decoded_metar = metar_decode(payload.metar);
		var str = decoded_metar.replace(/(?:\r\n|\r|\n)/g, '<br/>');
		$(this).find('.gip-body').html(str);
		$.dashboard.last_updated(msg, $(this));
		//$(this).find('.gip-footer').html('LAST UPDATED ' + moment().format('HH:mm')+ ' L');
	});
	
	
	$(selector).click(function() {
		var delayed_time = moment($.dashboard.get_time());
		// get scheduled flights (all positive numbers)
		$.post(
			"wire/get-metar",
			{
				'around': delayed_time.format('YYYY-MM-DD HH:mm')
			},
			function (r) {
				var ret = JSON.parse(r);
				$(selector).trigger('gip:message', {payload: JSON.stringify(ret[0])});
			}
		);
	});


});
<?php $this->endBlock(); ?>
</script>

<?php
$this->registerJs($this->blocks['JS_UPDATEMETAR'], yii\web\View::POS_READY);
