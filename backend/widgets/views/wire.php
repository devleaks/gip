<?php

use yii\helpers\Html;

use devleaks\sieve\Sieve;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */

$this->title = Yii::t('gip', 'The Wire');
$repeat = 120; // minutes
$last   = null;
?>
<div class="wire-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= Sieve::widget([
		'id' => 'the-wire',
		'pluginOptions' => [
			'itemSelector' => '.timeline-item'
		]
	]) ?>

	<ul id="<?= $id ?>" class="timeline">
		<?php
			foreach($dataProvider->query->each() as $model) {
				if(!$last) {
				    echo '<li class="time-label"><span class="bg-red">'.date("d M y h:m", strtotime($model->created_at)).'</span></li>';
					$last = $model->created_at;
				} else if (round(abs(strtotime($last) - strtotime($model->created_at)) / 60) > $repeat) {
				    echo '<li class="time-label"><span class="bg-red">'.date("d M y h:m", strtotime($model->created_at)).'</span></li>';
					$last = $model->created_at;
				}
				echo $this->render('_wire-timeline', ['model' => $model]);
			}
		?>
	</ul>
	
</div>
