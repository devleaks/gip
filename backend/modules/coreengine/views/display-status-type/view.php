<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\DisplayStatusType $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Status Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="display-status-type-view">

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
                'attribute'=>'created_at',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'created_by',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'displayOnly'=>true,
            ],
            [
                'attribute'=>'updated_by',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'displayOnly'=>true,
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
				'query' => $model->getDisplayStatuses(),
			]);

	        echo $this->render('../display-status/_list', [
	            'dataProvider' => $dataProvider,
				'display_status_type' => $model,
	        ]);
	?>


</div>
