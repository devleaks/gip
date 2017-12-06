<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\DeviceGroup $searchModel
 */

$this->title = Yii::t('gip', 'Device Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-group-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        	'display_name',
            'description',
			[
				'attribute' => 'type_id',
				'label' => Yii::t('gip', 'Dynamic Group'),
			],
            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'template' => '{tojson} {view} {update} {delete}',
                'buttons' => [
	                'update' => function ($url, $model) {
	                            	return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
											Yii::$app->urlManager->createUrl(['coreengine/device-group/view','id' => $model->id,'edit'=>'t']),
											['title' => Yii::t('yii', 'Edit')]);
								},
	                'tojson' => function ($url, $model) {
	                            	return Html::a('<span class="glyphicon glyphicon-download-alt"></span>',
											Yii::$app->urlManager->createUrl(['coreengine/device-group/tojson','id' => $model->id]),
											['title' => Yii::t('yii', 'Export')]);
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']).' '.
					  Html::a('<i class="glyphicon glyphicon-import"></i> Import', ['device/import'], ['class' => 'btn btn-primary']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
