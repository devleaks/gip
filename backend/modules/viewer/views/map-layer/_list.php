<?php

use common\models\MapLayer;

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Background $searchModel
 */
?>
<div class="background-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

        	'display_name',
            'description',
			[
				'attribute' => 'layerType.display_name',
				'label' => Yii::t('gip', 'Layer Type'),
			],
            'status',

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'controller' => 'map-layer',
				'template' => '{update} {delete}',
                'buttons' => [
                	'update' => function ($url, $model) use ($map) {
                            	return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
									Yii::$app->urlManager->createUrl(['/viewer/map-layer/view','id' => MapLayer::findOne(['map_id'=>$map->id, 'layer_id'=>$model->id])->id,'edit'=>'t']),
									['title' => Yii::t('yii', 'Edit'),]);
							},
                	'delete' => function ($url, $model) use ($map) {
                            	return Html::a('<span class="glyphicon glyphicon-trash"></span>',
									Yii::$app->urlManager->createUrl(['/viewer/map-layer/delete','id' => MapLayer::findOne(['map_id'=>$map->id, 'layer_id'=>$model->id])->id]),
									['title' => Yii::t('yii', 'Remove'),'data-confirm' => Yii::t('gip', 'Remove background?'),'data-method' => 'post']);
							},
                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode(Yii::t('gip', 'Layers')).' </h3>',
            'type'=>'info',
			'after'=>$this->render('_add', ['map'=>$map]),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
