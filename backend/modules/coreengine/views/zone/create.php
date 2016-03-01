<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Zone $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Zone',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Zones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
