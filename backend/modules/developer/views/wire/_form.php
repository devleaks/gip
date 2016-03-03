<?php

use common\models\EntityType;
use common\models\Wire;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use insolita\iconpicker\Iconpicker;
use kartik\widgets\ColorInput

/**
 * @var yii\web\View $this
 * @var common\models\Wire $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="wire-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

		if($model->icon) $model->icon = 'fa-'.$model->icon;

		echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'subject'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Wire Subject...', 'maxlength'=>160]],

        	'body'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Wire Body...', 'maxlength'=>2000]],

            'type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Wire Type...', 'maxlength'=>40], 'items' => EntityType::getTypesList(EntityType::CATEGORY_WIRE)],

            'link'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Icon...', 'maxlength'=>200]],

            'icon'=>['type'=> Form::INPUT_WIDGET,
					 'widgetClass' => Iconpicker::className(),
					 'options' => [
						'rows' => 6,
						'columns' => 8,
						'iconset'=> 'fontawesome',
						'options'=>['placeholder'=>'Enter Icon...', 'maxlength'=>40]
					 ]
			],

            'color'=>['type'=> Form::INPUT_WIDGET,
					 'widgetClass' => ColorInput::className(),
					 'options' => [
						'options'=>['maxlength'=>40]
					 ]
			],

            'status'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Status...', 'maxlength'=>40], 'items' => Wire::getLocalizedConstants('STATUS_')],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
