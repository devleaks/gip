<?php

/**
 * @var yii\web\View $this
 * @var \yii\bootstrap\Widget $widget
 */
?>
<div id="<?= $widget->id ?>"
	class="giplet"
	data-widget-name="<?= $widget->className() ?>"
	>
	<span class="info-box-icon bg-info"><i class="fa fa-cloud update-metar"></i></span>

	<div class="info-box-content">
		<div class="raw" style="text-align: left;">
		</div>
		<span class="last-updated"></span>

	</div><!-- /.info-box-content -->
</div><!-- /.info-box -->
<script type="text/javascript">
<?php $this->beginBlock('JS_UPDATEMETAR') ?>
//console.log('giplet update metar');
$('.update-metar').click(function () {
	var giplet = $(this).parents('.giplet');
	var vname = giplet.data('widget-name');
	var vid = giplet.attr('id');
	console.log('giplet '+ vname + ':' + vid);
	
	$.post(
		'metar',
	    {icao: 'EBLG'},
		function (r) {
			s = JSON.parse(r);
			t = s.metar;
			console.log(t);
			u = metar_decode(t);
			str = u.replace(/(?:\r\n|\r|\n)/g, '<br/>');
			giplet.find('.raw').html(str);
			giplet.find('.last-updated').html(new Date());
	    }
	);
	//console.log('giplet updated');
});
<?php $this->endBlock(); ?>
</script>

<?php
$this->registerJs($this->blocks['JS_UPDATEMETAR'], yii\web\View::POS_READY);
