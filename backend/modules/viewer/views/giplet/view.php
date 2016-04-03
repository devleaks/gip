<?php

use common\models\Giplet;
use common\models\GipletType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Giplet $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Giplets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giplet-view">

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
	            'attribute'=>'giplet_type_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(GipletType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'label' => Yii::t('gip', 'Giplet Type'),
	            'value'=>isset($model->gipletType) ? $model->gipletType->display_name : '',
	        ],
	        [
	            'attribute'=>'parameters',
				'type' => DetailView::INPUT_TEXTAREA,
	        ],
			'width_min',
			'width_max',
			'height_min',
			'height_max',
			[
				'attribute' => 'can_move',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'can_resize',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'can_minimize',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'can_remove',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'can_spawn',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'has_options',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
	        [
	            'attribute'=>'status',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => Giplet::getLocalizedConstants('STATUS_'),
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

	<?php
			$dataProvider = new ActiveDataProvider([
				'query' => $model->getParameters(true),
			]);

	        echo $this->render('../../../common/views/attribute-value/_list', [
	            'dataProvider' => $dataProvider,
				'model' => $model,
	        ]);
	?>

</div>
