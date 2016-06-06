<?
$giplet_class="gip-aodb-qfu";

?>
<div id="gip-aodb-qfu"
	 class="card card-bordered style-info gip-indicator"
>
	<span class="gip-header">QFU</span><br/>
	<span class="gip-body" data-gip="value">23</span><br/>
	<span class="gip-footer" data-gip="note">L / R</span>
</div>

<script type="text/javascript">
<?php $this->beginBlock('JS_AODB_QFU') ?>
jQuery(document).ready(function($){

$("#gip-aodb-qfu").on('gip:message', function(event, msg) {
	var payload = $.parseJSON(msg.body);
	for (var property in payload) {
		$(this).find("[data-gip="+property+"]").html(payload[property]);
	}
	return false;
});

});
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_AODB_QFU'], yii\web\View::POS_READY);
