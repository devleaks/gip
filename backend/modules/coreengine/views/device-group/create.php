<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\DeviceGroup $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Device Group',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Device Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-group-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
