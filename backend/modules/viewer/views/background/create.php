<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Background $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Background',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Backgrounds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="background-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
