<?php

use common\models\AttributeType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Attribute $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Attributes'), 'url' => ['index']];
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
            'name',
        	'display_name',
            'description',
			[
				'attribute' => 'attribute_type_id',
				'label' => Yii::t('gip', 'Attribute Type'),
				'value'=>isset($model->attributeType) ? $model->attributeType->display_name : '',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(AttributeType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
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
