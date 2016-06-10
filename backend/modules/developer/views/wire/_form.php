<?php

use common\models\Type;
use common\models\Wire;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use insolita\iconpicker\Iconpicker;
use kartik\widgets\ColorInput;
use kartik\widgets\DateTimePicker;
use devgroup\jsoneditor\Jsoneditor;

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

        	'body'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Wire Body...', 'maxlength'=>2000]],

            'payload'=>['type'=> Form::INPUT_WIDGET,
					 'widgetClass' => Jsoneditor::className(),
					 'options' => [
				        'editorOptions' => [
				            'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
				            'mode' => 'tree', // current mode
				        ],
				        'model' => $model, // input name. Either 'name', or 'model' and 'attribute' properties must be specified.
						'attribute' => 'payload',
				        'options' => [], // html options
				    ]
			],

            'link'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Link URL...', 'maxlength'=>200]],

            'source_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Wire Source...', 'maxlength'=>40], 'items' => Type::forClass(Wire::className().':source')],

            'type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Wire Type...', 'maxlength'=>40], 'items' => Type::forClass(Wire::className().':type')],

            'priority'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Priority...', 'maxlength'=>4]],

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

        	'note'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Note (testing only)...', 'maxlength'=>160]],

            'expired_at'=>['type'=> Form::INPUT_WIDGET,
	            'widgetClass' => DateTimePicker::className(), 
	            'hint'=>'Enter Expiration Date and Time'
			],

            'status'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Status...', 'maxlength'=>40], 'items' => Wire::getLocalizedConstants('STATUS_')],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

    ActiveForm::end(); ?>

</div>
