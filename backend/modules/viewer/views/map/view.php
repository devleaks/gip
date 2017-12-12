<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Map $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-view">
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
			'center',
	        [
	            'attribute'=>'zoom',
				'type' => DetailView::INPUT_SPIN,
				'widgetOptions' => [
				    'pluginOptions' => [
				        'initval' => 12.00,
				        'min' => 0,
				        'max' => 19,
				        'step' => 0.1,
				        'decimals' => 2,
				        'boostat' => 1,
				        'maxboostedstep' => 2,
				    ]
				]		
	        ]
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
				'query' => $model->getLayers(),
			]);
	        echo $this->render('../map-layer/_list', [
	            'dataProvider' => $dataProvider,
				'map' => $model,
	        ]);
	?>

	<?php
			$dataProvider = new ActiveDataProvider([
				'query' => $model->getToolGroups(),
			]);
	        echo $this->render('../map-tool-group/_list', [
	            'dataProvider' => $dataProvider,
				'map' => $model,
	        ]);
	?>

</div>
