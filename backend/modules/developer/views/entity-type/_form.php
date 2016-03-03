<?php

use common\models\EntityType;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\EntityType $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="entity-type-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'category'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Category...', 'maxlength'=>40], 'items' => EntityType::getLocalizedConstants('CATEGORY_')],

            'icon'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Icon...', 'maxlength'=>40]],

            'color'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Color...', 'maxlength'=>40]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
