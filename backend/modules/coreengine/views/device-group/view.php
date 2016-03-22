<?php

use common\models\Device;

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\DeviceGroup $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Device Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-group-view">

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
	            'attribute'=>'device_type',
				'type' => DetailView::INPUT_DROPDOWN_LIST,
				'items' => [''=>'']+Device::getDeviceTypes(),
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

	<?php 	if($model->device_type == '') {
				echo $this->render('../group/group', [
					'model'		=> $model,
		            'outgroup'  => $outgroup,
		            'ingroup'   => $ingroup,
				]);
			} else {
				echo $this->render('../group/_list', [
					'dataProvider' => new ActiveDataProvider([
						'query' => $model->getDevices()
					]),
						'title' => Yii::t('gip', 'Devices in Dynamic Group'),
				]);
			}
	?>
</div>
