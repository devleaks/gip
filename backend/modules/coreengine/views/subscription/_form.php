<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Subscription $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="subscription-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'service_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Service ID...']],

            'rule_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Rule ID...']],

            'source_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Source ID...']],

            'enabled'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Enabled...']],

            'trusted'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Trusted...']],

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

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
