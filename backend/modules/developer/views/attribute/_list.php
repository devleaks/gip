<?php

use common\models\EntityAttribute;

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Attribute $searchModel
 */
?>
<div class="attribute-index">

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
			[
				'attribute' => 'attributeType.name',
				'label' => Yii::t('gip', 'Attribute Type')
			],
/*		   	'position',
			[
				'attribute' => 	'mandatory',
	            'value' => function ($model, $key, $index, $widget) {
							return $model->mandatory ? Yii::t('gip', 'True') : Yii::t('gip', 'False');
	            		},
			],
*/            [
                'class' => 'yii\grid\ActionColumn',
				'controller' => 'attribute',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['developer/attribute/view','id' => $model->id,'edit'=>'t']), [
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode(Yii::t('gip', 'Attributes')).' </h3>',
            'type'=>'info',
             'showFooter'=>false
        ],
    ]); Pjax::end(); ?>


	<?php
		$ea = new EntityAttribute();
		$ea->entity_type = $model::className();
		$ea->entity_id = $model->id;
		echo $this->render('_add', ['model'=>$ea]);
	?>


</div>
