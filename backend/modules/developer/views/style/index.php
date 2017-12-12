<?php

use common\models\Type;

use yii\helpers\Html;
use yii\helpers\Url;
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
							return $model->getHtml();
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
			[
				'label' => Yii::t('gip', 'Stroke and Fill'),
				'format' => 'raw',
				'value' => function ($model, $key, $index, $widget) {
						$pattern = intval($model->fill_pattern) > 0 ? Type::findOne($model->fill_pattern)->name : '';
						$color = $model->fill_color ? $model->fill_color : '#888888';
						return '<div class="css_pattern"><div style="width: 40px; height: 40px; float:left; color: '.$color.'" class="pattern-swatch '.$pattern.'"></div></div>'
						     . " <span class='badge' style='float:right; background-color: {$model->fill_color}'> </span>";
           		},
				'hAlign' => GridView::ALIGN_CENTER,
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{view} {update} {duplicate} {delete}',
                'buttons' => [
	                'update' => function ($url, $model) {
	                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/style/view','id' => $model->id,'edit'=>'t']), [
	                                                    'title' => Yii::t('yii', 'Edit'),
	                                ]);
								},
			        'duplicate' => function ($url, $model) {
			                    	return Html::a('<span class="glyphicon glyphicon-duplicate"></span>',
											Url::To(['duplicate','id' => $model->id]),
											['title' => Yii::t('yii', 'Duplicate')]);
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
