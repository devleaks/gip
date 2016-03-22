<?php

use common\models\Type;
use common\models\Wire;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\icons\Icon;
use insolita\iconpicker\Iconpicker;

/**
 * @var yii\web\View $this
 * @var common\models\Wire $model
 */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Wires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wire-view">

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
            'subject',
            [
				'attribute' => 'body',
            	'type'=> DetailView::INPUT_TEXTAREA,
				'options' => ['rows' => 10],
			],
           'link',
            [
				'attribute' => 'type_id',
				'items' => Type::forClass(Wire::className()),
            	'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'value' => $model->type ? $model->type->display_name : '',
			],
            [
				'attribute' => 'icon',
				'value' => Icon::show(str_replace('fa-', '', $model->icon)),
				'format' => 'raw',
            	'type'=> DetailView::INPUT_WIDGET,
				'widgetOptions' => [
					'class' => Iconpicker::className(),
					'rows' => 6,
					'columns' => 8,
					'iconset'=> 'fontawesome',
				],
			],
			[
                'attribute' => 'color', 
                'format' => 'raw', 
                'value' => "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" . $model->color . '</code>',
                'type'=> DetailView::INPUT_COLOR,
                'valueColOptions' => ['style'=>'width:30%'], 
            ],
            [
				'attribute' => 'status',
        		'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'items' => Wire::getLocalizedConstants('STATUS_'),
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
