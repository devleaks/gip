<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Dashboard $searchModel
 */

$this->title = Yii::t('gip', 'Dashboards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

        	'display_name',
            'description',

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{view} {update} {delete} {render} {test}',
                'buttons' => [
                	'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
													Yii::$app->urlManager->createUrl(['/viewer/dashboard/view','id' => $model->id,'edit'=>'t']),
													['title' => Yii::t('yii', 'Edit'),
                                                  ]);},
                	'render' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-picture"></span>',
													Yii::$app->urlManager->createUrl(['/viewer/dashboard/render','id' => $model->id]),
													['title' => Yii::t('yii', 'Render'),
                                                  ]);},
                	'test' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-play-circle"></span>',
													Yii::$app->urlManager->createUrl(['/dashboard/view','id' => $model->id]),
													['title' => Yii::t('yii', 'Test'),
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
