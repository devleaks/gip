<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Provider $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Provider',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
