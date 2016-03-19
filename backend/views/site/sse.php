<?php
/* @var $this \yii\web\View */
?>
<div>
    Event:
    <ul id="response">
    </ul>
</div>
<?php
$url = \yii\helpers\Url::to(['/site/message'],true);
$js = <<<JS
    var evtSource = new EventSource("$url");
    evtSource.onmessage = function(e) {
        $('<li>').css({color:'red'}).text(e.data).appendTo('#response');
    }
    evtSource.addEventListener("ping", function(e) {
        var obj = JSON.parse(e.data);
        $('<li>').text("ping at " + obj.time).appendTo('#response
    });
JS;
$this->registerJs($js);