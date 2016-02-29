<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Service $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Service',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
