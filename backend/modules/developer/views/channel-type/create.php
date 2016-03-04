<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ChannelType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Channel Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Channel Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
