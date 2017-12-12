<?php

use common\models\Type;
use common\models\Zone;

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Zone $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Zones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-view">

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
	            'attribute'=>'zone_dimension',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ['2D' => '2D', '3D' => '3D'],
				'label' => Yii::t('app', 'Dimensions')
	        ],
            'geometry',
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
