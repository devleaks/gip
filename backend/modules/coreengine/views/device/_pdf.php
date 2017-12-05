<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Device */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Device'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('gip', 'Device').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'hidden' => true],
        'name',
        'description'
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
    $gridColumnDeviceDeviceGroup = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'hidden' => true],
        [
                'attribute' => 'deviceGroup.display_name',
                'label' => Yii::t('gip', 'Device Group')
        ],
        [
                'attribute' => 'device.display_name',
                'label' => Yii::t('gip', 'Device')
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerDeviceDeviceGroup,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-device-device-group']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('gip', 'Device Device Group').' '. $this->title),
        ],
        'columns' => $gridColumnDeviceDeviceGroup
    ]);
?>
    </div>
</div>
