<?php

use frontend\widgets\Indicator;
use frontend\widgets\Metar;

use fedemotta\gridstack\Gridstack;

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$gridstack->beginWidget([
		'class'=>'grid-stack-item',
		'data-gs-width'=>"2",
		'data-gs-height'=>"2",
    ]);
?>
<div class="grid-stack-item-content">
	<span class="drag fa"></span>
	<?= Indicator::widget([
			'color' => 'green',
			'item' => "Seconds",
			'icon' => 'fa-clock-o',
			'value' => date('s', time()),
			'autoUpdate' => 5,
		  ]);
	?>
</div>
<?=$gridstack->endWidget();