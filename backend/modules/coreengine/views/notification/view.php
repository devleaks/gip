<?php

use common\models\NotificationType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Notification $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-view">

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
				'attribute' => 'notification_type_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Notification Type'),
				'items' => ArrayHelper::map(NotificationType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
	            'value' => isset($model->notificationType) ? $model->notificationType->display_name : '',
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
