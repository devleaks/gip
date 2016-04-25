<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Style $model
 */

$this->title = Yii::t('gip', 'Update {modelClass}: ', [
    'modelClass' => 'Style',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Styles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('gip', 'Update');
?>
<div class="style-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
