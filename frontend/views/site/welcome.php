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
				'data-gs-width'=>"3",
				'data-gs-height'=>"2",
		    ]);
		?>
		<div class="grid-stack-item-content">
			<span class="drag fa"></span>
			<?= Indicator::widget([
					'item' => "I'm an indicator!",
					'icon' => 'fa-cog'
				  ]);
			?>
		</div>
		<?=$gridstack->endWidget();?>
		
		
		
		<?= $gridstack->beginWidget([
				'class'=>'grid-stack-item',
				'data-gs-width'=>"3",
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
					'progressDescription' => '62% done.'
				  ]);
			?>
		</div>
		<?=$gridstack->endWidget();?>
		



	<?php $gridstack->end(); ?>

</div><!-- .site-welcome -->
