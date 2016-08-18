<?php

use common\models\DashboardGiplet;

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

        	'position',
			[
				'attribute' => 'giplet.display_name',
				'label' => Yii::t('gip', 'Giplet Name'),
			],
			[
				'attribute' => 'giplet.gipletType.display_name',
				'label' => Yii::t('gip', 'Giplet Type'),
			],
            'giplet.description',

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
				'controller' => 'dashboard-giplet',
				'template' => '{update} {delete}',
                'buttons' => [
                	'update' => function ($url, $model) use ($dashboard) {
                            	return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
									Yii::$app->urlManager->createUrl(['/viewer/dashboard-giplet/view',
																		'id' => $model->id,
																		'edit'=>'t']),
																	 	['title' => Yii::t('yii', 'Edit'),]);
							},
                	'delete' => function ($url, $model) use ($dashboard) {
                            	return Html::a('<span class="glyphicon glyphicon-trash"></span>',
									Yii::$app->urlManager->createUrl(['/viewer/dashboard-giplet/delete',
																		'id' => $model->id]),
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode(Yii::t('gip', 'Giplets')).' </h3>',
            'type'=>'info',
			'after'=>$this->render('_add', ['dashboard'=>$dashboard]),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
