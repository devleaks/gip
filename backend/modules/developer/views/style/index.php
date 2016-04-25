<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Style $searchModel
 */

$this->title = Yii::t('gip', 'Styles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="style-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'display_name',
            'description',
	        [
				'label' => Yii::t('gip', 'Font Name & Size'),
				'width' => '70px',
				'attribute' => 'font_name',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return $model->font_name ? "<span class='badge' style='font: {$model->font_name}'>".$model->font_name."</span>"
													: '';
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
	        [
				'label' => Yii::t('gip', 'Icon & Color'),
				'width' => '70px',
				'attribute' => 'glyph',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return $model->glyph ? Icon::show(str_replace('fa-', '', $model->glyph), ['style' => 'color:'.$model->stroke_color])
												: "<span class='badge' style='background-color: {$model->stroke_color}'> </span>";
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
	        [
				'label' => Yii::t('gip', 'Stroke'),
				'width' => '70px',
				'attribute' => 'stroke_color',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return "<span class='badge' style='background-color: {$model->stroke_color}'> </span>";
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
			//            'stroke_width', 
			//            'stroke_style', 
	        [
				'label' => Yii::t('gip', 'Fill'),
				'width' => '70px',
				'attribute' => 'fill_color',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return "<span class='badge' style='background-color: {$model->fill_color}'> </span>";
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
//            'fill_pattern', 

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/style/view','id' => $model->id,'edit'=>'t']), [
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
