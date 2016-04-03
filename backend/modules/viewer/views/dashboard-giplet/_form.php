<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\DashboardGiplet $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="dashboard-giplet-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

'dashboard_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Dashboard ID...']],

'giplet_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Giplet ID...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
