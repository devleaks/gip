<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\GipletType $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Giplet Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giplet-type-view">

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
				'query' => $model->getEntityAttributes()->orderBy('position'),
			]);

	        echo $this->render('../../../common/views/entity-attribute/_list', [
	            'dataProvider' => $dataProvider,
				'model' => $model,
	        ]);
	?>

</div>
