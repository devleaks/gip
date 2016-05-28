<?php
use common\models\Wire as Wire;

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Model to display */
?>
<li style="display: list-item;" data-tags="wire">
    <i class="fa <?=$model->icon?> bg-blue"></i>
    <div class="timeline-item timeline-<?=strtolower($model->type->name)?>">
		<span class="time">
        <i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDateTime(time()) ?></span>
        <h3 class="timeline-header">
			<input type="checkbox" class="wire-checkbox" <?= $model->status == Wire::STATUS_UNREAD ? ' ' : 'disabled checked'?> data-message="<?= $model->id ?>">
			&nbsp;<a href="<?=Url::to(['wire/view', 'id'=>$model->id])?>" title="<?= Html::encode($model->subject) ?>"
				style="color: <?=strtolower($model->color)?>"><?= Html::encode($model->subject) ?></a></h3>
        <div class="timeline-body">
        <?= Html::encode($model->body) ?>
        </div>

        <div class="timeline-footer">
            <a class="btn btn-<?=strtolower($model->type->name)?> btn-xs"><?= Yii::t('gip', 'Published on {0}', Yii::$app->formatter->asDateTime($model->created_at)) ?></a>
			<?php if($model->expired_at) {
			 		if ($model->expired_at < date('Y-m-d H:i:s')) {
						echo '<span class="expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Expired since {0}', Yii::$app->formatter->asDateTime($model->expired_at));
				  	} else {
						echo '<span class="not-expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Expires at {0}', Yii::$app->formatter->asDateTime($model->expired_at));
					}
				}
			?>
			<?php if($model->ack_at) {
					echo '<span class="expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Acknowledge at {0}', Yii::$app->formatter->asDateTime($model->ack_at));
				  } else if ($model->status == Wire::STATUS_UNREAD) {
					if($model->expired_at) {
				 		if ($model->expired_at < date('Y-m-d H:i:s')) {
							echo '<span class="not-expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Required acknowledgement before {0}', Yii::$app->formatter->asDateTime($model->expired_at));
					  	} else {
							echo '<span class="not-expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Requires acknowledgement before {0}', Yii::$app->formatter->asDateTime($model->expired_at));
						}
					} else {
						echo '<span class="not-expired"><i class="fa fa-warning"></i> '.Yii::t('gip', 'Requires acknowledgement');
					}
				  }
			?>
        </div>
    </div>
</li>