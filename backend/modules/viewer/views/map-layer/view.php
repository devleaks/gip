<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\SwitchInput;

/**
 * @var yii\web\View $this
 * @var common\models\MapLayer $model
 */

$this->title = $model->layer->display_name;
$this->params['breadcrumbs'][] = ['label' => $model->map->display_name, 'url' => ['map/view', 'id' => $model->map_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-layer-view">

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'position',
            'group',
			[
		        'attribute' => 'default',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'options' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
            'status',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
