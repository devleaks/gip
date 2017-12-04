<?php

use common\models\Type;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use insolita\iconpicker\Iconpicker;
use kartik\widgets\ColorInput

/**
 * @var yii\web\View $this
 * @var common\models\Type $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="type-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'action' => 'create']);
	echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display Name...', 'maxlength'=>80]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>40], 'items' => Type::forClass(Type::className())],

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

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
