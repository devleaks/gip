<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Wire $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Wire',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Wires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
