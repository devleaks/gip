<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EntityType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Entity Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Entity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
