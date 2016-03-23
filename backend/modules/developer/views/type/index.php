<?php

use common\models\Type;

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Type $searchModel
 */

$this->title = Yii::t('gip', 'Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

        	'display_name',
	        'name',
	        'description',
	        [
				'label' => Yii::t('gip', 'Entity'),
				'attribute' => 'type_id',
				'filter' => Type::forClass(Type::className()),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->type->name;
	            		},
			],
	        [
				'label' => Yii::t('gip', 'Icon & Color'),
				'width' => '70px',
				'attribute' => 'icon',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							if($model->icon)
								return Icon::show(str_replace('fa-', '', $model->icon), ['style' => 'color:'.$model->color]);
							else
								return "<span class='badge' style='background-color: {$model->color}'> </span>";
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],/*
			[
			    'attribute'=>'color',
			    'value'=>function ($model, $key, $index, $widget) {
			        return "<span class='badge' style='background-color: {$model->color}'> </span>";
			    },
			    'width'=>'8%',
			    'vAlign'=>'middle',
			    'format'=>'raw',
				'filter' => false,
			],*/
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/type/view','id' => $model->id,'edit'=>'t']), [
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
