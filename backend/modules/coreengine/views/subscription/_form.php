<?php

use common\models\Provider;
use common\models\Rule;
use common\models\Service;

use yii\helpers\ArrayHelper;
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

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'service_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Service...'], 'items' => ArrayHelper::map(Service::find()->orderBy('name')->asArray()->all(), 'id', 'name')],

            'rule_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Rule...'], 'items' => ArrayHelper::map(Rule::find()->orderBy('name')->asArray()->all(), 'id', 'name')],

            'provider_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Provider...'], 'items' => ArrayHelper::map(Service::find()->orderBy('name')->asArray()->all(), 'id', 'name')],

            'enabled'=>['type'=> Form::INPUT_CHECKBOX, 'options'=>['placeholder'=>'Enter Enabled...']],

            'trusted'=>['type'=> Form::INPUT_CHECKBOX, 'options'=>['placeholder'=>'Enter Trusted...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
