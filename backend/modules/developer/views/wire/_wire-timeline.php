<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Model to display */
?>
<li>
    <i class="fa <?=$model->icon?> bg-blue"></i>
    <div class="timeline-item">
        <span class="time"><i class="fa fa-clock-o"></i> <?= date('h:m', $model->created_at) ?></span>
        <h3 class="timeline-header"><a href="#"><?= Html::encode($model->subject) ?></a> ...</h3>
        <div class="timeline-body">
        <?= Html::encode($model->body) ?>
        </div>

        <div class="timeline-footer">
            <a class="btn btn-primary btn-xs">...</a>
        </div>
    </div>
</li>