<?php

/**
 * @var yii\web\View $this
 * @var \yii\bootstrap\Widget $widget
 */
?>
<div class="info-box <?= $widget->colorBG ? 'bg-' . $widget->color : '' ?>">
	<span class="info-box-icon <?= !$widget->colorBG ? 'bg-' . $widget->color : '' ?>"><i class="fa <?= $widget->icon ?>"></i></span>

	<div class="info-box-content">
		<span class="info-box-text"><?= $widget->item ?></span>
		<span class="info-box-number"><?= $widget->count ?></span>

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
