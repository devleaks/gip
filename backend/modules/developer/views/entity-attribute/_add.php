<?php

use common\models\Attribute;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\... (vary) */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-attribute-form">

    <div>
    	<h3><?= Html::encode(Yii::t('gip', 'Add Attribute')) ?></h3>
    </div>

	<?php $form = ActiveForm::begin([
			'action' => Url::to(['/developer/entity-attribute/create'])
          ]);
	?>
	
    <?= Html::activeHiddenInput($model, 'entity_id') ?>
    <?= Html::activeHiddenInput($model, 'entity_type') ?>

	<?= Form::widget([
			    'model' => $model,
			    'form' => $form,
			    'columns' => 12,
			    'attributes' => [				
					'attribute_id' => [
						'type' => Form::INPUT_DROPDOWN_LIST,
						'items' => ArrayHelper::map(Attribute::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
						'label' => Yii::t('gip', 'Attribute'),
			            'columnOptions' => ['colspan' => 3],
					],
			        'position' => [
						'type' => Form::INPUT_TEXT,
			            'columnOptions' => ['colspan' => 1],
					],
			        'description' => [
						'type' => Form::INPUT_TEXT,
			            'columnOptions' => ['colspan' => 6],
					],
			        'mandatory' => [
						'type' => Form::INPUT_WIDGET,
						'widgetClass'=> SwitchInput::className(),
						'options' => [
						    'pluginOptions' => [
								'onText' => Yii::t('store', 'Yes'),
								'offText' =>  Yii::t('store', 'No')
							],
						],
			            'columnOptions' => ['colspan' => 1],
					],
				],
			])
	?>
	
    <div class="form-group">
    <?= Html::submitButton(Yii::t('store', 'Add Attribute'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
