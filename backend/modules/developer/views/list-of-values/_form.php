<?php

use common\models\AttributeType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\ListOfValues $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="list-of-values-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>200]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>200]],

            'data_type'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Data Type...', 'maxlength'=>255], 'items' => AttributeType::getLocalizedConstants('DATA_TYPE_')],

            'table_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Table Name...', 'maxlength'=>200]],

            'value_column_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Value Column Name...', 'maxlength'=>80]],

            'display_column_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display Column Nam...', 'maxlength'=>80]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
