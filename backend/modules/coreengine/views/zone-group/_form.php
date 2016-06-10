<?php

use common\models\Zone;
use common\models\DisplayStatusType;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\ZoneGroup $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="zone-group-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>40]],

        	'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>160]],

        	'description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Description...', 'maxlength'=>2000]],

            'zone_type'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Zone Type for Dynamic Group...'], 'items' => [''=>'']+Zone::getZoneTypes()],

			'display_status_type_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter Display Status Type...'], 'items' => [''=>'']+DisplayStatusType::getList()],
/*
            'zone_group_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Zone Group Type...']],

            'schema_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Schema Name...', 'maxlength'=>80]],

            'table_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Table Name...', 'maxlength'=>80]],

            'unique_id_column'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unique Id Column...', 'maxlength'=>80]],

            'geometry_column'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Geometry Column...', 'maxlength'=>80]],

            'where_clause'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Where Clause...', 'maxlength'=>4000]],
*/
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
