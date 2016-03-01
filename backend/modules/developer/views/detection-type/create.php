<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\DetectionType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Detection Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Detection Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detection-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
