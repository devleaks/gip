<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\TargetType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Target Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Target Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
