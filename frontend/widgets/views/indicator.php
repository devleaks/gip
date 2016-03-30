<?php

/**
 * @var yii\web\View $this
 * @var \yii\bootstrap\Widget $widget
 */
?>
<div id="<?= $widget->id ?>"
	class="giplet info-box <?= $widget->colorBG ? 'bg-' . $widget->color : '' ?>"
	data-widget-name="<?= $widget->className() ?>"
	>
	<span class="info-box-icon <?= !$widget->colorBG ? 'bg-' . $widget->color : '' ?>"><i class="fa <?= $widget->icon ?>  update-me"></i></span>

	<div class="info-box-content">
		<span class="info-box-text"><?= $widget->item ?></span>
		<span class="info-box-number update-value"><?= $widget->value ?></span>

	<?php if($widget->progress): ?>
		<div class="progress">
		      <div class="progress-bar" style="width: <?= intval($widget->progress) ?>%"></div>
		</div>
		<span class="progress-description">
		<?= $widget->progressDescription ?>
		</span>
	<?php endif; ?>

	</div><!-- /.info-box-content -->
</div><!-- /.info-box -->
<script type="text/javascript">
<?php $this->beginBlock('JS_UPDATE') ?>
//console.log('giplet update');
$('.update-me').click(function () {
	var giplet = $(this).parents('.giplet');
	var vname = giplet.data('widget-name');
	var vid = giplet.attr('id');
	//console.log('giplet '+ vname + ':' + vid);
	$.post(
		'dashboard/update',
	    { name: vname, id: vid },
		function (r) {
			s = JSON.parse(r);
			giplet.find('.update-value').html(s.r);
			giplet.find('.progress-bar').css('width', 100*parseInt(s.r)/60);
			//console.log(s.r);
	    }
	);
	//console.log('giplet updated');
});
<?php $this->endBlock(); ?>
</script>

<?php
$this->registerJs($this->blocks['JS_UPDATE'], yii\web\View::POS_READY);
