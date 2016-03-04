<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Event $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Event',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Target Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
