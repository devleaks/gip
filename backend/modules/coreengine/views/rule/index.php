<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Rule $searchModel
 */

$this->title = Yii::t('gip', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

			'name',
            'description', 
			[
				'attribute' => 'device_group_id',
				'label' => Yii::t('gip', 'Device Group'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->deviceGroup ? $model->deviceGroup->name : '';
	            		},
			],
			[
				'attribute' => 'notification_group_id',
				'label' => Yii::t('gip', 'Notification Group'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->notificationGroup ? $model->notificationGroup->name : '';
	            		},
			],
			[
				'attribute' => 'detection_type_id',
				'label' => Yii::t('gip', 'Detection Type'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->detectionType ? $model->detectionType->name : '';
	            		},
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['coreengine/rule/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
