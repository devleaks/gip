<?php

use common\models\Event;
use common\models\TargetType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Target $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-view">

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
	            'attribute'=>'channel_type_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(TargetType::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'label' => Yii::t('gip', 'Target Type'),
	            'value'=>isset($model->providerType) ? $model->providerType->display_name : '',
	        ],
	        [
	            'attribute'=>'event_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(Event::find()->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Target Event'),
	            'value'=>isset($model->event) ? $model->event->display_name : '',
	        ],
            [
                'attribute'=>'created_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
				'displayOnly' => true,
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
				'displayOnly' => true,
            ],
            [
                'attribute'=>'created_by',
				'displayOnly' => true,
            ],
            [
                'attribute'=>'updated_by',
				'displayOnly' => true,
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
