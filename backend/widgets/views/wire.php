<?php

use yii\helpers\Html;

use devleaks\sieve\Sieve;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */

$this->title = Yii::t('gip', 'The Wire');
?>
<div class="wire-wrapper">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<header class="wire-top">
		<div class="wire-seave row">
			<div class="col-lg-12">
				<?= Sieve::widget([
					'id' => 'the-wire',
					'pluginOptions' => [
						'itemSelector' => '.wire-message'
					]
				]) ?>
			</div>
		</div>

		<div class="wire-tagsort row">
			<div class="tagsort-tags-container col-lg-12 ">
			</div>  
		</div>
	</header>

	<div class="wire-body row">
		<div class="col-lg-12">
			<ul id="<?= $id ?>" class="timeline">
				<?php
					if($widget->wire_count != 0) {
						foreach($dataProvider->query->each() as $model) {
							if(!$widget->last) {
							    echo '<li class="time-label"><span class="bg-blue">'.date("d M h:m", strtotime($model->created_at)).'</span></li>';
								$widget->last = $model->created_at;
							} else if (round(abs(strtotime($widget->last) - strtotime($model->created_at)) / 60) > $widget->repeat) {
							    echo '<li class="time-label"><span class="bg-blue">'.date("d M h:m", strtotime($model->created_at)).'</span></li>';
								$widget->last = $model->created_at;
							}
							echo $this->render('_wire-timeline', ['model' => $model]);
						}
					}
				?>
			</ul>
		</div>
	</div>
	
</div>
