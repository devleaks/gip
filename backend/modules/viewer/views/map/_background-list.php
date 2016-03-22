<?php

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

            'name',
        	'display_name',
            'description',
			[
				'attribute' => 'backgroundType.display_name',
				'label' => Yii::t('gip', 'Background Type'),
			],
            'status',

            [
                'class' => 'kartik\grid\ActionColumn',
				'noWrap' => true,
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['viewer/background/view','id' => $model->id,'edit'=>'t']), [
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode(Yii::t('gip', 'Background')).' </h3>',
            'type'=>'info',
			'after'=>$this->render('_background-add', ['map'=>$model]),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
