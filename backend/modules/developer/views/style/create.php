<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Style $model
 */

$this->title = Yii::t('gip', 'Create {modelClass}', [
    'modelClass' => 'Style',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Styles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="style-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
