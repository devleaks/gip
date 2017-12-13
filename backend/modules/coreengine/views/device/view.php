<?php

use common\models\Device;
use common\models\Type;

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use devgroup\jsoneditor\Jsoneditor;

/**
 * @var yii\web\View $this
 * @var common\models\Device $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="device-view">

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
            'name',
        	'display_name',
            'description',
	        [
	            'attribute'=>'type_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+Type::forClass($model::className()),
				'value' => (isset($model->type_id) && intval($model->type_id) > 0)? $model->type->display_name : '',
				'label' => Yii::t('app', 'Type')
	        ],
	        [
				'attribute' => 'geojson',
	        	'type'=> DetailView::INPUT_WIDGET,
				'format' => 'raw',
				'value' => '<pre>'.json_encode(json_decode($model->geojson), JSON_PRETTY_PRINT).'</pre>',
				'widgetOptions' => [
					'class' => Jsoneditor::className(),
					'options' => [
				        'editorOptions' => [
				            'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
				            'mode' => 'tree', // current mode
				        ],
						'attribute' => 'geojson',
				        'options' => [], // html options
				    ],
				],
			],
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
