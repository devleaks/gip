<?php

/* @var $this yii\web\View */
/* @var $gridstack fedemotta\gridstack\Gridstack */
/* @var $giplet common\models\Giplet */


$gridstack_widget = [];

$gridstack_widget['class'] = 'grid-stack-item';

$gridstack_widget['data-gs-width'] = $giplet->width_min;
$gridstack_widget['data-gs-height'] = $giplet->height_min;

$gridstack_widget['data-gs-min-width'] = $giplet->width_min;
$gridstack_widget['data-gs-max-width'] = $giplet->width_min;
$gridstack_widget['data-gs-min-height'] = $giplet->width_min;
$gridstack_widget['data-gs-max-height'] = $giplet->width_min;

if(! $giplet->can_move) $gridstack_widget['data-gs-no-move'] = 1;
if(! $giplet->can_resize) $gridstack_widget['data-gs-no-resize'] = 1;
// if($giplet->locked) $gridstack_widget['data-gs-locked'] = 1;


echo $gridstack->beginWidget($gridstack_widget);
?>
<div class="grid-stack-item-content"
	 data-gip-giplet-id="<?= $giplet->id ?>"
>
	<?php if($giplet->can_move): ?>
	<span class="drag fa"></span>
	<?php endif; ?>
	<?php
		if($widget = $giplet->gipletType->factory) {
			$giplet_params = [];
			foreach(explode(',', $giplet->parameters) as $nv) {
				$d = explode('=', str_replace("'", "", str_replace('"', '', $nv)));
				$giplet_params[$d[0]] = $d[1];
			}
			echo $giplet->gipletType->factory::widget($giplet_params);
		} else {
			echo Yii::t('gip', '{0} has no widget.', $giplet->name);
		}
	?>
</div><!-- .grid-stack-item-content -->

<?= $gridstack->endWidget();