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
 * @var common\models\search\Attribute $searchModel
 */
?>
<div class="attribute-index">
	
	<?php $form = ActiveForm::begin(['action' => ['attribute-value/batch-update']]);

    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
		'form' => $form,
        'attributes' => [
	        'attribute_id' => [
				'label' => Yii::t('gip', 'Attribute'),
	            'type' => TabularForm::INPUT_STATIC, 
	            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT],
				'value' => function ($model, $key, $index, $widget) {
							return $model->entityAttribute->name;
	            		},
	        ],
            'value_text' => [
            	'type' => TabularForm::INPUT_TEXT,
			],
            'value_number' => [
            	'type' => TabularForm::INPUT_TEXT,
			],
            'value_date' => [
            	'type' => TabularForm::INPUT_TEXT,
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
