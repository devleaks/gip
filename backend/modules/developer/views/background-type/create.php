<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\BackgroundType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Background Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Background Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="background-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
