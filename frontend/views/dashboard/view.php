<?php

use fedemotta\gridstack\Gridstack;

/* @var $this yii\web\View */
$this->title = $model->display_name;
?>
<div class="dashboard-view body-content">

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
	
	<?php foreach($model->getDashboardGiplets()->orderBy('position')->each() as $dg) {
			echo $this->render('_giplet-in-gridstack', [
				'gridstack' => $gridstack,
				'giplet' => $dg->giplet
			]);
		}
	?>

	<?php $gridstack->end(); ?>

</div><!-- .site-welcome -->
