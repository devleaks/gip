<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use insolita\iconpicker\Iconpicker;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Tool $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="tool-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'icon'=>['type'=> Form::INPUT_WIDGET,
					 'widgetClass' => Iconpicker::className(),
					 'options' => [
						'rows' => 6,
						'columns' => 8,
						'iconset'=> 'fontawesome',
						'options'=>['placeholder'=>'Enter Icon...', 'maxlength'=>40]
					 ]
			],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
