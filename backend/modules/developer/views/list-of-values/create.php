<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ListOfValues $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'List Of Values',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'List Of Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-of-values-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
