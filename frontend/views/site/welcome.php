<?php

use frontend\widgets\Indicator;

use fedemotta\gridstack\Gridstack;

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'GIP Application Dashboard';
?>
<div class="site-welcome body-content">

	<?php $gridstack = Gridstack::begin([
	    'options' =>[
			'class'=>'grid-stack'
		],
	    'clientOptions'=>[
	        'verticalMargin'=> 10,
			'cellHeight' => 50,
			'float' => true,
			'handle' => '.drag'
	    ]
	]);?>
	
		<?= $gridstack->beginWidget([
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
					'value' => date('s', time())
				  ]);
			?>
		</div>
		<?=$gridstack->endWidget();?>
		
		
		
		<?= $gridstack->beginWidget([
				'class'=>'grid-stack-item',
				'data-gs-width'=>"2",
				'data-gs-height'=>"2",
		    ]);
		?>
		<div class="grid-stack-item-content">
			<span class="drag fa"></span>
			<?= Indicator::widget([
					'color' => 'red',
					'colorBG' => true,
					'icon' => 'fa-envelope-o',
					'progress' => 60,
					'item' => 'Mail',
					'progressDescription' => '62% done.'
				  ]);
			?>
		</div>
		<?=$gridstack->endWidget();?>

		

		<?= $gridstack->beginWidget([
				'class'=>'grid-stack-item',
				'data-gs-width'=>"2",
				'data-gs-height'=>"2",
		    ]);
		?>
		<div class="grid-stack-item-content">
			<span class="drag fa"></span>
			<?= Indicator::widget(); ?>
		</div>
		<?=$gridstack->endWidget();?>
		


	<?php $gridstack->end(); ?>

</div><!-- .site-welcome -->
