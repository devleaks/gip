<?php

use common\models\Wire as WireModel;
use backend\widgets\Wire;

$this->title = 'GIP - Live Wire';
?>
<div class="wire container">

	<?= Wire::widget([
		'id' => 'the-wire',
		'statuses' => [WireModel::STATUS_PUBLISHED, WireModel::STATUS_UNREAD],
		'live' => true,
		'wire_count' => 0
	]) ?>
	
</div>