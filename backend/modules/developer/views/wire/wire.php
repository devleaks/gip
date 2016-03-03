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
?>
<div class="wire-index">

	<ul class="timeline">
	    <li class="time-label">
	        <span class="bg-red">
	            <?= date('d M y') ?>
	        </span>
	    </li>
	    <?= ListView::widget([
	        'dataProvider' => $dataProvider,
			'summary' => false,
			'itemOptions' => false,
			'options' => false,
			'itemView' => '_wire-timeline'
	    ]); ?>
	</ul>
	
</div>
