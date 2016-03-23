<?php

use common\models\AttributeType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\SwitchInput;

/**
 * @var yii\web\View $this
 * @var common\models\Attribute $model
 */
$controller = '/developer/'.$model->getEntityController().'/view';
$this->title = $model->getEntityName(); // Yii::t('gip', 'Entity Attribute');
$this->params['breadcrumbs'][] = ['label' => $model->getEntityName(), 'url' => [$controller, 'id' => $model->entity_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-view">

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
			[
				'attribute' => 'attribute_id',
				'displayOnly' => true,
				'label' => 'Attribute',
				'value' => $model->entityAttribute->display_name,
			],
			'position',
			'description',
			[
				'attribute' => 'mandatory',
				'format' => 'boolean',
				'type' => DetailView::INPUT_SWITCH,
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'attribute_id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
