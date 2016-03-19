<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'GIP - Message of the Day';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">Welcome to <?= Yii::$app->name ?>.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/']) ?>">Get started with <?= Yii::$app->name ?>!</a></p>
    </div>

    <div class="body-content">

        <div class="row">
	
            <div class="col-lg-2 col-lg-offset-3">
                <h3>Input</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/inputbroker/processing']) ?>">Devices</a></li>
                </ul>

            </div>

            <div class="col-lg-2">
                <h3>Processing</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/coreengine/rule']) ?>">Rules</a></li>
				</ul>
            </div>

            <div class="col-lg-2">
                <h3>Views</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/viewer/dashboard']) ?>">Dashboards</a></li>
				</ul>
            </div>

        </div>

        <div class="row">
            <h3>Messages</h3>
			<div id="message" class="col-lg-8 col-lg-offset-2" style="border: 1px solid grey;"> </div>
    	</div>

    </div>
</div>
<script type="text/javascript">
<?php
$this->beginBlock('JS_GETMOTD') ?>
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("<?= Url::to(['get-motd']) ?>");
	console.log('source set');
    source.onmessage = function(event) {
		console.log('got message...');
        $("#message").prepend(event.data).fadeIn(); // We want to display new messages above the stack
    };
}
else {
    $("#message").replaceWith("<div class=\"flash-notice\">Sorry, your browser doesn\'t support SSE.<br>Hint: get a real one :-)</div>");
}
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_GETMOTD'], yii\web\View::POS_END);