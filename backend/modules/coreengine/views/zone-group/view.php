<?php

use common\models\Zone;

use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ZoneGroup $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Zone Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-group-view">

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
	            'attribute'=>'zone_type',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+Zone::getZoneTypes(),
	        ],
/*            'zone_group_type',
            'schema_name',
            'table_name',
            'unique_id_column',
            'geometry_column',
            'where_clause',
*/        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

	<?php 	if($model->zone_type == '') {
				echo $this->render('../group/group', [
					'model'		=> $model,
		            'outgroup'  => $outgroup,
		            'ingroup'   => $ingroup,
				]);
			} else {
				echo $this->render('../group/_list', [
					'dataProvider' => new ActiveDataProvider([
						'query' => $model->getZones()
					]),
					'title' => Yii::t('gip', 'Zones in Group'),
				]);
			}
	?>
</div>