<?php

use common\models\Style;
use common\models\Type;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\icons\Icon;
use insolita\iconpicker\Iconpicker;

/**
 * @var yii\web\View $this
 * @var common\models\Type $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type->display_name, 'url' => ['index', 'Type[type_id]' => $model->type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-view">

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
            [
				'attribute' => 'type_id',
				'items' => Type::forClass(Type::className()),
            	'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'value' => $model->type ? $model->type->display_name : '',
				'label' => Yii::t('app', 'Base Type')
			],
            'name',
        	'display_name',
            'description',
	        [
	            'attribute'=>'style_id',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+ArrayHelper::map(Style::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
				'value' => (isset($model->style_id) && intval($model->style_id) > 0)? $model->style->display_name : '',
				'label' => Yii::t('app', 'Style')
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
		if($model->getTypes()->exists()) { // list of values based on table:
			$dataProvider = new ActiveDataProvider([
				'query' => $model->getTypes(),
			]);

	        echo $this->render('_list', [
	            'dataProvider' => $dataProvider,
				'type' => $model,
	        ]);
		}
	?>

</div>
