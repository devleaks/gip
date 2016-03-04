<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */

$this->title = Yii::t('gip', 'The Wire');
$this->params['breadcrumbs'][] = $this->title;
$repeat = 120; // minutes
$last   = null;
?>
<div class="wire-index">

	<ul class="timeline">
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
