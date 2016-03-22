<?php

use common\models\AttributeType;
use common\models\ListOfValues;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\AttributeType $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Attribute Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-type-view">

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
				'attribute' => 'data_type',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => AttributeType::getLocalizedConstants('DATA_TYPE_'),
	        ],
	        [
	            'attribute'=>'list_of_values_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(['' => ''] + ListOfValues::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'label' => Yii::t('gip', 'List of Values'),
	            'value'=>isset($model->listOfValues) ? $model->listOfValues->display_name : '',
	        ],
	        [
	            'attribute'=>'created_at',
	            'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
	            'type'=>DetailView::INPUT_WIDGET,
	            'widgetOptions'=> [
	                'class'=>DateControl::classname(),
	                'type'=>DateControl::FORMAT_DATETIME
	            ]
	        ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            'created_by',
            'updated_by',
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
