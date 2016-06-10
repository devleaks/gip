<?php

use common\models\Style;

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\DisplayStatus $searchModel
 */

$this->title = Yii::t('gip', 'Display Statuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="display-status-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'display_status_type_id',
            'name',
            'display_name',
            'description',
			[
				'attribute' => 'style_id',
				'filter' => Style::getList(),
	            'value' => function ($model, $key, $index, $widget) {
							return $model->style_id ? $model->style->name : '';
	            		},
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['coreengine/display-status/view','id' => $model->id,'edit'=>'t']), [
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
