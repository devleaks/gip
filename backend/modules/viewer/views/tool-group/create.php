<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ToolGroup $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Tool Group',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Tool Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-group-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
