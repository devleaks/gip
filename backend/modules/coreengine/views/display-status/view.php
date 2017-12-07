<?php

use common\models\Style;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\DisplayStatus $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->displayStatusType->display_name, 'url' => ['display-status-type/view', 'id' => $model->display_status_type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="display-status-view">

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
	            'attribute'=>'style_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+ArrayHelper::map(Style::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'value' => (isset($model->style_id) && intval($model->style_id) > 0)? $model->style->display_name : '',
				'label' => Yii::t('app', 'Style')
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
