<?php

use common\models\AttributeType;
use common\models\ListOfValues;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\AttributeType $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="attribute-type-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Display Name...', 'maxlength'=>80]],

        	'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>200]],

            'data_type'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Data Type...', 'maxlength'=>255], 'items' => AttributeType::getLocalizedConstants('DATA_TYPE_')],

            'attribute_type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Sub Attribute Type...'], 'items' => ArrayHelper::map(['' => ''] + AttributeType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),'label'=>Yii::t('gip', 'Sub Attribute Type')],

            'list_of_values_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter List Of Values ID...'], 'items' => ArrayHelper::map(['' => ''] + ListOfValues::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],


        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
