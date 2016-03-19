<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Dashboard $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Dashboard',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
