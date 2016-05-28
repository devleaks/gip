<?php

use backend\widgets\Wire;

$this->title = 'GIP - Live Wire';
?>
<div class="site-wire" style="overflow: auto;">

	<?= Wire::widget([
		'id' => 'the-wire',
		'statuses' => ['PUBLISHED'],
		'live' => true
	]) ?>
	
	<form id="wire-chat-form">
        <input id="wire-chat-inputext" type="text" class="form-control" placeholder="Text input" style="width: 100%;" maxlength="140" autocomplete="off">
    </form>
    
</div>