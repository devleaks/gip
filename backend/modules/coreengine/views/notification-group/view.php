<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var common\models\NotificationGroup $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Notification Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-group-view">

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

	<?php 	echo $this->render('../group/group', [
				'model'		=> $model,
		        'outgroup'  => $outgroup,
		        'ingroup'   => $ingroup,
			]);
	?>
</div>
