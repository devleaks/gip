<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Device $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Device',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
