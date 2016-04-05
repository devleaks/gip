<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\DisplayStatusType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Display Status Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Status Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="display-status-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
