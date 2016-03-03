<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Model to display */
?>
<div class="box box-<?= strtolower($model->type->name) ?>">

    <h4><?= Html::encode($model->subject) ?></h4>

    <?= Html::encode($model->body) ?>

</div>