<?php

use common\models\Tool;
use common\models\Type;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\ToolGroup $model
 */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Tool Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-group-view">

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
				'attribute' => 'type_id',
				'items' => ['' => ''] + Type::forClass(Tool::className()),
            	'type'=> DetailView::INPUT_DROPDOWN_LIST,
				'value' => $model->type ? $model->type->display_name : '',
				'label' => Yii::t('gip', 'Type')
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


	<?php 	if($model->type_id == '') {
				echo $this->render('@backend/modules/coreengine/views/group/group', [
					'model'		=> $model,
		            'outgroup'  => $outgroup,
		            'ingroup'   => $ingroup,
				]);
			} else {
				echo $this->render('@backend/modules/coreengine/views/group/_list', [
					'dataProvider' => new ActiveDataProvider([
						'query' => $model->getTools()
					]),
						'title' => Yii::t('gip', 'Tools in Dynamic Group'),
				]);
			}
	?>
</div>
