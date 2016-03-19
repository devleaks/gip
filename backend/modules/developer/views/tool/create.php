<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Tool $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Tool',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Tools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
