<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\LovValues $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Lov Values',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Lov Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lov-values-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
