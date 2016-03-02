<?php

use common\models\Event;
use common\models\EventType;
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
            'description',
	        [
	            'attribute'=>'service_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Service::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Service'),
	            'value'=>isset($model->service) ? $model->service->name : '',
	        ],
	        [
	            'attribute'=>'provider_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Provider::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Provider'),
	            'value'=>isset($model->provider) ? $model->provider->name : '',
	        ],
	        [
	            'attribute'=>'event_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Event::find()->andWhere(['event_type_id' => EventType::getTargetEventID()])->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Target Event'),
	            'value'=>isset($model->event) ? $model->event->name : '',
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
