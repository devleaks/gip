<?php

use common\models\EntityType;
use common\models\Wire;

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Wire $searchModel
 */

$this->title = Yii::t('gip', 'Wires');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'subject',
				'value' => function($model, $key, $index, $widget) {
					return $model->link ?
							Html::a($model->subject, $model->link)
							:
							$model->subject;
				},
			],
            [
				'attribute' => 'type_id',
				'filter' => EntityType::getTypesList(EntityType::CATEGORY_WIRE),
				'value' => function ($model, $key, $index, $widget) {
							return $model->type->name;
	            		},
			],
	        [
				'attribute' => 'icon',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return Icon::show(str_replace('fa-', '', $model->icon));
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
			[
			    'attribute'=>'color',
			    'value'=>function ($model, $key, $index, $widget) {
			        return "<span class='badge' style='background-color: {$model->color}'> </span>";
			    },
			    'width'=>'8%',
			    'vAlign'=>'middle',
			    'format'=>'raw',
				'filter' => false,
			],
            [
				'attribute' => 'status',
				'filter' => Wire::getLocalizedConstants('STATUS_'),
			],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/wire/view','id' => $model->id,'edit'=>'t']), [
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
