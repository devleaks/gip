<?php

use common\models\GipletType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\SwitchInput;
use kartik\widgets\TouchSpin;

/**
 * @var yii\web\View $this
 * @var common\models\Giplet $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="giplet-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40], 'columnOptions' => ['colspan' => 4]],

        	'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display Name...', 'maxlength'=>80], 'columnOptions' => ['colspan' => 4]],

        	'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000], 'columnOptions' => ['colspan' => 4]],

        	'giplet_type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Giplet Type...'], 'items' => ArrayHelper::map(GipletType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'), 'columnOptions' => ['colspan' => 4]],

			'width_min' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> TouchSpin::className(),
				'options' => ['pluginOptions' => [
					'initval' => 1,
					'min' => 1,
					'max' => 30
				]],
	            'columnOptions' => ['colspan' => 2],
			],

			'width_max' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> TouchSpin::className(),
				'options' => ['pluginOptions' => [
					'initval' => 1,
					'min' => 1,
					'max' => 30
				]],
	            'columnOptions' => ['colspan' => 2],
			],

			'height_min' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> TouchSpin::className(),
				'options' => ['pluginOptions' => [
					'initval' => 1,
					'min' => 1,
					'max' => 30
				]],
	            'columnOptions' => ['colspan' => 2],
			],

			'height_max' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> TouchSpin::className(),
				'options' => ['pluginOptions' => [
					'initval' => 1,
					'min' => 1,
					'max' => 30
				]],
	            'columnOptions' => ['colspan' => 2],
			],

			'can_move' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],
			'can_resize' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],
			'can_minimize' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],
			'can_remove' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],
			'can_spawn' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],
			'has_options' => [
				'type' => Form::INPUT_WIDGET,
				'widgetClass'=> SwitchInput::className(),
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				]
			],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
