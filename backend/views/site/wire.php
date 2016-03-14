<?php

use kartik\daterange\MomentAsset;

MomentAsset::register($this);

$this->title = 'GIP - Wire';

?>
<div id="chat"  class="site-index" style="overflow: auto;">
	<ul id="the-wire" class="timeline">
	</ul>
</div>
<script type="text/javascript">
<?php
$this->beginBlock('JS_WIRE') ?>

$(function(){
	function addWire(icon, color, priority, title, text) {
	    $("#the-wire").append(
			$('<li>')
			.append(
				$('<i>').addClass('fa').addClass('fa-'+icon).addClass('bg-'+color).html(' ')
			)
			.append( $('<div>').addClass('timeline-item').addClass('timeline-danger')
				.append( $('<span>').addClass('time')
					.append(
						$('<i>').addClass('fa').addClass('fa-clock-o').html(' '+moment(new Date()).format('MM/DD/YY HH:mm'))
					)
				)
				.append( $('<h3>').addClass('timeline-header').html(title) )
				.append( $('<div>').addClass('timeline-body').html(text) )
				.append( $('<div>').addClass('timeline-footer')
					.append(
						$('<a>').addClass('btn').addClass('btn-'+priority).addClass('btn-xs').html('Published on '+moment(new Date()).format('MM/DD/YY HH:mm'))
					)
				)
			)
		);
	};

    function wsStart() {
        ws = new WebSocket("ws://imac.local:8051/");
        ws.onopen = function() { addWire('warning', 'green', 'info', 'Opening...', "... connected."); };
        ws.onclose = function() { addWire('warning', 'red', 'info', 'Closing...', "Connection closed. Trying to reconnect..."); setTimeout(wsStart, 1000);};
        ws.onmessage = function(evt) { addWire('comment', 'blue', 'success', 'Message', evt.data); $('#the-wire').scrollTop($('#the-wire')[0].scrollHeight);};
    }

	addWire('warning', 'yellow', 'info', 'Connection', "Connecting to server...");	
    wsStart();
});

<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_WIRE'], yii\web\View::POS_END);