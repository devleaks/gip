<?php

use common\models\Style;
use common\models\Type;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use insolita\iconpicker\Iconpicker;
use kartik\widgets\ColorInput

/**
 * @var yii\web\View $this
 * @var common\models\Style $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="style-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display Name...', 'maxlength'=>40]],

'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

'font_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Font Name...', 'maxlength'=>200]],

'font_size'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>40], 'items' => Type::forClass(Style::FONT_SIZES)],

'glyph'=>['type'=> Form::INPUT_WIDGET,
		 'widgetClass' => Iconpicker::className(),
		 'options' => [
			'rows' => 6,
			'columns' => 8,
			'iconset'=> 'fontawesome',
			'options'=>['placeholder'=>'Enter Glyph...', 'maxlength'=>40]
		 ]
],

'glyph_size'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Font Size...', 'maxlength'=>10]],

'stroke_width'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Stroke Width...']],

'stroke_style'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>40], 'items' => Type::forClass(Style::STROKE_TYPES)],

'stroke_color'=>['type'=> Form::INPUT_WIDGET,
		 'widgetClass' => ColorInput::className(),
		 'options' => [
			'options'=>['maxlength'=>40]
		 ]
],

'fill_pattern'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>40], 'items' => Type::forClass(Style::FILL_PATTERNS)],

'fill_color'=>['type'=> Form::INPUT_WIDGET,
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
