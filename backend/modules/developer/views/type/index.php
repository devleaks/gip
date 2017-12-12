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
				'label' => Yii::t('gip', 'Style'),
				'width' => '70px',
				'attribute' => 'glyph',
				'filter' => false,
	            'value' => function ($model, $key, $index, $widget) {
							return $model->style_id > 0 ? $model->style->getHtml() : '';
	            		},
				'format' => 'raw',
				'hAlign' => GridView::ALIGN_CENTER,
	        ],
	        [
				'label' => Yii::t('gip', 'Entity'),
				'attribute' => 'type_id',
				'filter' => Type::forClass(Type::className()),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->type->name;
	            		},
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{view} {update} {duplicate} {delete}',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/type/view','id' => $model->id,'edit'=>'t']), [
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
