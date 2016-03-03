<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Model to display */
?>
<li>
    <i class="fa <?=$model->icon?> bg-blue"></i>
    <div class="timeline-item timeline-<?=strtolower($model->type->name)?>">
        <span class="time"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDateTime($model->created_at) ?></span>
        <h3 class="timeline-header"><a href="<?=Url::to(['view', 'id'=>$model->id])?>" title="<?= Html::encode($model->subject) ?>"
				class="text-<?=strtolower($model->type->name)?>"><?= Html::encode($model->subject) ?></a></h3>
        <div class="timeline-body">
        <?= Html::encode($model->body) ?>
        </div>

        <div class="timeline-footer">
            <a class="btn btn-<?=strtolower($model->type->name)?> btn-xs">Published on <?= Yii::$app->formatter->asDateTime($model->created_at) ?></a>
        </div>
    </div>
</li>