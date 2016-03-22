<?php

use common\models\DeviceGroup;
use common\models\NotificationGroup;
use common\models\DetectionType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Rule $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="rule-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

            'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'device_group_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Device Group...'], 'items' => ArrayHelper::map(DeviceGroup::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],

            'notification_group_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Notification Group...'], 'items' => ArrayHelper::map(NotificationGroup::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],

            'detection_type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Notification Group...'], 'items' => ArrayHelper::map(DetectionType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
