<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Subscription $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Subscription',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
