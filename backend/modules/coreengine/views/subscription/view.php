<?php

use common\models\Provider;
use common\models\Rule;
use common\models\Service;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Subscription $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-view">

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
				'attribute' => 'service_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Service'),
				'items' => ArrayHelper::map(Service::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
	            'value' => isset($model->service) ? $model->service->display_name : '',
			],
			[
				'attribute' => 'rule_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Rule'),
				'items' => ArrayHelper::map(Rule::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
	            'value' => isset($model->rule) ? $model->rule->display_name : '',
			],
			[
				'attribute' => 'provider_id',
				'type'  => DetailView::INPUT_DROPDOWN_LIST,
				'label' => Yii::t('gip', 'Provider'),
				'items' => ArrayHelper::map(Provider::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
	            'value' => isset($model->provider) ? $model->provider->display_name : '',
			],
			[
				'attribute' => 'enabled',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
			],
			[
				'attribute' => 'trusted',
				'type' => DetailView::INPUT_SWITCH,
				'format' => 'boolean',
				'widgetOptions' => [
				    'pluginOptions' => [
						'onText' => Yii::t('store', 'Yes'),
						'offText' =>  Yii::t('store', 'No')
					],
				],
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
