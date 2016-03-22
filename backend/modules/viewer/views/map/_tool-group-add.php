<?php

use common\models\ToolGroup;
use common\models\MapToolGroup;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\... (vary) */
/* @var $form yii\widgets\ActiveForm */

$model = new MapToolGroup();
$model->map_id = $map->id;

?>

<div class="entity-attribute-form">

	<?php $form = ActiveForm::begin([
			'action' => Url::to(['tool-group-add'])
          ]);
	?>
	
    <?= Html::activeHiddenInput($model, 'map_id') ?>

	<?= Form::widget([
			    'model' => $model,
			    'form' => $form,
			    'columns' => 12,
			    'attributes' => [				
					'tool_group_id' => [
						'type' => Form::INPUT_DROPDOWN_LIST,
						'items' => ArrayHelper::map(ToolGroup::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
						'label' => Yii::t('gip', 'Tool Set'),
			            'columnOptions' => ['colspan' => 3],
					],
			        'position' => [
						'type' => Form::INPUT_TEXT,
			            'columnOptions' => ['colspan' => 1],
					],
				],
			])
	?>
	
    <?= Html::submitButton(Yii::t('store', 'Add Tool Set'), ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
