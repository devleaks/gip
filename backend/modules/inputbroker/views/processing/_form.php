<?php

use common\models\Event;
use common\models\Provider;
use common\models\Processing;
use common\models\Service;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Processing $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="processing-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

        	'service_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Service...', 'maxlength'=>255], 'items' => ArrayHelper::map(Service::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],

        	'provider_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Service...', 'maxlength'=>255], 'items' => ArrayHelper::map(Provider::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name')],

        	'event_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Service...', 'maxlength'=>255], 'items' => ArrayHelper::map(Event::find()->asArray()->all(), 'id', 'name')],

            'status'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Data Type...', 'maxlength'=>255], 'items' => Processing::getLocalizedConstants('STATUS_')],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
