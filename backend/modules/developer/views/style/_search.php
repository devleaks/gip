<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\search\Style $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="style-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'display_name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'fontname') ?>

    <?php // echo $form->field($model, 'glyph') ?>

    <?php // echo $form->field($model, 'stroke_width') ?>

    <?php // echo $form->field($model, 'stroke_style') ?>

    <?php // echo $form->field($model, 'stroke_color') ?>

    <?php // echo $form->field($model, 'fill_pattern') ?>

    <?php // echo $form->field($model, 'fill_color') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('gip', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('gip', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
