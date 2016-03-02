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
            ['class' => 'yii\grid\SerialColumn'],
            'name', 
            'description', 
			[
				'attribute' => 'service_id',
				'label' => Yii::t('gip', 'Service'),
				'filter' => ArrayHelper::map(Service::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->service ? $model->service->name : '';
	            		},
			],
			[
				'attribute' => 'rule_id',
				'label' => Yii::t('gip', 'Rule'),
				'filter' => ArrayHelper::map(Rule::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->rule ? $model->rule->name : '';
	            		},
			],
			[
				'attribute' => 'provider_id',
				'label' => Yii::t('gip', 'Source'),
				'filter' => ArrayHelper::map(Provider::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->provider ? $model->provider->name : '';
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
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['coreengine/subscription/view','id' => $model->id,'edit'=>'t']), [
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
