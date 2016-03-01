<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ZoneGroup $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Zone Group',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Zone Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-group-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
