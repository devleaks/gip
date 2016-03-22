<?php

use common\models\Target;
use common\models\Processing;
use common\models\Provider;
use common\models\Service;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Processing $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Processings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="processing-view">

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
	            'attribute'=>'service_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Service::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'label' => Yii::t('gip', 'Service'),
	            'value'=>isset($model->service) ? $model->service->display_name : '',
	        ],
	        [
	            'attribute'=>'provider_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Provider::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'label' => Yii::t('gip', 'Provider'),
	            'value'=>isset($model->provider) ? $model->provider->display_name : '',
	        ],
	        [
	            'attribute'=>'target_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Target::find()->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Target'),
	            'value'=>isset($model->event) ? $model->event->display_name : '',
	        ],
	        [
	            'attribute'=>'status',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => Processing::getLocalizedConstants('STATUS_'),
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
				'query' => $model->getMappings(true),
			]);

	        echo $this->render('_mapping', [
	            'dataProvider' => $dataProvider,
				'model' => $model,
	        ]);
	?>
</div>
