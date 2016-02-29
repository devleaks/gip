<?php

use common\models\AttributeType;

use yii\helpers\Html;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\ListOfValues $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'List Of Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-of-values-view">

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
				'attribute' => 'data_type',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => AttributeType::getLocalizedConstants('DATA_TYPE_'),
	        ],
            'table_name',
            'value_column_name',
            'display_column_name',
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
		if($model->table_name != '') { // list of values based on table:
			$q = new Query();
			$q->select([
				'id' => $model->value_column_name,
				'name' => $model->display_column_name
			])
			  ->from($model->table_name)
			  ->orderBy($model->display_column_name)
			;
			
			$dataProvider = new ActiveDataProvider([
				'query' => $q,
			]);
	        echo $this->render('../lov-values/_list_t', [
	            'dataProvider' => $dataProvider,
				'list_of_values' => $model,
	        ]);
		} else { // static list of values
			$dataProvider = new ActiveDataProvider([
				'query' => $model->getLovValues(),
			]);

	        echo $this->render('../lov-values/_list', [
	            'dataProvider' => $dataProvider,
				'list_of_values' => $model,
	        ]);
		}
	?>


</div>
