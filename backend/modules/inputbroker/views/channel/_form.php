<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Channel $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="channel-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

            'channel_type_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Channel Type ID...']],

            'event_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Event ID...']],

            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],

            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],

            'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

            'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
