<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\GipletType $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Giplet Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Giplet Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giplet-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
