<?php

use common\models\EntityAttribute;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */
?>
<div class="attribute-index">

    <?php $form = ActiveForm::begin(['action' => 'mappings']);

	    echo TabularForm::widget([
	        'dataProvider' => $dataProvider,
			'form' => $form,
	        'attributes' => [
				'attribute_in' => [
					'label' => Yii::t('gip', 'Source Attribute'),
					'type' => TabularForm::INPUT_DROPDOWN_LIST,
					'items' => function ($model, $key, $index, $widget) {
						return [''=>''] + $model->processing->provider->event->getParametersList();
			        },
					'value' => function ($model, $key, $index, $widget) {
						return $model->processing->provider->event->name;
			        },
				],
				'attribute_out' => [
					'type' => TabularForm::INPUT_STATIC,
					'label' => Yii::t('gip', 'Target Attribute'),
			        'value' => function ($model, $key, $index, $widget) {
						return $model->attributeOut ? $model->attributeOut->name : '';
			        },
				],
			
	        ],
			'gridSettings' => [
			        'floatHeader' => true,
			        'panel' => [
			            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> '.Yii::t('gip', 'Attributes').'</h3>',
			            'type' => GridView::TYPE_INFO,
			            'after'=> 
			                Html::submitButton(
			                    '<i class="glyphicon glyphicon-floppy-disk"></i> Save', 
			                    ['class'=>'btn btn-primary']
			                )
			        ]
			],
			'actionColumn' => false,
			'checkboxColumn' => false,
	    ]);
		ActiveForm::end(); ?>
	
</div>
