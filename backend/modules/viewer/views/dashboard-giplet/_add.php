<?php

use common\models\Giplet;
use common\models\DashboardGiplet;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\... (vary) */
/* @var $form yii\widgets\ActiveForm */

$model = new DashboardGiplet();
$model->dashboard_id = $dashboard->id;

?>

<div class="entity-attribute-form">

	<?php $form = ActiveForm::begin([
			'action' => Url::to(['giplet-add'])
          ]);
	?>
	
    <?= Html::activeHiddenInput($model, 'dashboard_id') ?>

	<?= Form::widget([
			    'model' => $model,
			    'form' => $form,
			    'columns' => 12,
			    'attributes' => [				
					'giplet_id' => [
						'type' => Form::INPUT_DROPDOWN_LIST,
						'items' => ArrayHelper::map(Giplet::find()->orderBy('display_name')->asArray()->all(), 'id', 'display_name'),
						'label' => Yii::t('gip', 'Giplet'),
			            'columnOptions' => ['colspan' => 3],
					],
			        'position' => [
						'type' => Form::INPUT_TEXT,
			            'columnOptions' => ['colspan' => 1],
					],
		            
				],
			])
	?>
	
    <?= Html::submitButton(Yii::t('store', 'Add Giplet'), ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
