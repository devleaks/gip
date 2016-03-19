<?php

use common\models\BackgroundType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Background $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="background-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'background_type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Background Type...'], 'items' => ArrayHelper::map(BackgroundType::find()->orderBy('name')->asArray()->all(), 'id', 'name')],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
