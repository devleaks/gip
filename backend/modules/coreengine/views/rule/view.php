<?php

use common\models\DeviceGroup;
use common\models\NotificationGroup;
use common\models\DetectionType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var common\models\Rule $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


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
				'attribute' => 'device_group_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Notification Type'),
				'items' => ArrayHelper::map(DeviceGroup::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => isset($model->deviceGroup) ? $model->deviceGroup->name : '',
			],
			[
				'attribute' => 'notification_group_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Notification Type'),
				'items' => ArrayHelper::map(NotificationGroup::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => isset($model->notificationGroup) ? $model->notificationGroup->name : '',
			],
			[
				'attribute' => 'detection_type_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Notification Type'),
				'items' => ArrayHelper::map(DetectionType::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
	            'value' => isset($model->detectionType) ? $model->detectionType->name : '',
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
