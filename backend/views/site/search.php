<?php

use frontend\widgets\Search;

use common\models\Competition;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SeasonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('gip', 'Search Results');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-result">
	
	<h2><?= Html::encode($this->title) ?></h2>

    <?= Search::widget([
		'query' => $query,
		'detail_urls' => [
			'competition' => '/admin/competition/view',
			'event' => '/admin/event/view',
			'message' => '/admin/message/view',
		],
	]); ?>

</div>
