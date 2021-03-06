<?php

use app\models\Backup;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BackupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('gip', 'Backups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Administration'), 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-download"></i> '.Html::encode($this->title).' </h3>',
            'before'=>false,
            'showFooter'=>false
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'filename',
            'note',
            'created_at',
            'status',

            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{delete} {restore}',
				'buttons' => [
					'restore' => function ($url, $model) {
						return defined('YII_DEVLEAKS') ? 
									Html::a('<span class="glyphicon glyphicon-warning-sign"></span>', Url::to(['restore-dev', 'id' => $model->id]), [
										'title' => Yii::t('gip', 'Restore database only'),
										'data-confirm' => Yii::t('gip', 'Restore database?')
									]) : '';
					}
				],
			],
        ],
    ]); ?>

	<div class="parameter-form">

	    <?php $form = ActiveForm::begin(['action' => Url::to(['create'])]); ?>

	    <?= $form->field($model, 'note')->textInput(['maxlength' => 160]) ?>

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('gip', 'Create Backup'), ['class' => 'btn btn-success']) ?>
	    </div>
	    <?php ActiveForm::end(); ?>

	</div>

</div>
