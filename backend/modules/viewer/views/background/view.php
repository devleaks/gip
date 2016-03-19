<?php

use common\models\BackgroundType;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Background $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Backgrounds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="background-view">

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
	            'attribute'=>'background_type_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => ArrayHelper::map(BackgroundType::find()->asArray()->all(), 'id', 'name'),
				'label' => Yii::t('gip', 'Background Type'),
	            'value'=>isset($model->backgroundType) ? $model->backgroundType->name : '',
	        ],
            'status',
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
