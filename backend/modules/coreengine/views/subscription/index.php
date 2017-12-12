<?php

use common\models\Provider;
use common\models\Rule;
use common\models\Service;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Subscription $searchModel
 */

$this->title = Yii::t('gip', 'Subscriptions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'display_name', 
            'description', 
			[
				'attribute' => 'service_id',
				'label' => Yii::t('gip', 'Service'),
				'filter' => Service::getList(),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->service ? $model->service->display_name : '';
	            		},
			],
			[
				'attribute' => 'rule_id',
				'label' => Yii::t('gip', 'Rule'),
				'filter' => Rule::getList(),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->rule ? $model->rule->display_name : '';
	            		},
			],
			[
				'attribute' => 'provider_id',
				'label' => Yii::t('gip', 'Source'),
				'filter' => Provider::getList(),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->provider ? $model->provider->display_name : '';
	            		},
			],
			[
				'attribute' => 'enabled',
				'filter' => [0 => Yii::t('gip', 'No'), 1 => Yii::t('gip', 'Yes')],
				'format' => 'boolean',
			],
			[
				'attribute' => 'trusted',
				'filter' => [0 => Yii::t('gip', 'No'), 1 => Yii::t('gip', 'Yes')],
				'format' => 'boolean',
			],

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['coreengine/subscription/view','id' => $model->id,'edit'=>'t']), [
                                   'title' => Yii::t('yii', 'Edit'),
                    ]);
				}
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
