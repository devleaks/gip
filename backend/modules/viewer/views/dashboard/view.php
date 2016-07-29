<?php

use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var common\models\Dashboard $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-view">

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
		        'attribute' => 'layout',
				'format' => 'raw',
				'value' => Html::a('<span class="glyphicon glyphicon-pencil"></span> '.Yii::t('yii', 'Edit'),
									['design','id' => $model->id],
									['title' => Yii::t('yii', 'Modify layout'), 'target' => '_blank']
				)
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
				'query' => $model->getDashboardGiplets(),
			]);
	        echo $this->render('../dashboard-giplet/_list', [
	            'dataProvider' => $dataProvider,
				'dashboard' => $model,
	        ]);
	?>



</div>
