<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\DisplayStatusType $model
 */

$this->title = Yii::t('gip', 'Update {modelClass}: ', [
    'modelClass' => 'Display Status Type',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Status Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('gip', 'Update');
?>
<div class="display-status-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
