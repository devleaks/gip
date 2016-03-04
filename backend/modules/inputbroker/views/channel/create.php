<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Channel $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Channel',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
