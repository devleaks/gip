<?php

use backend\models\CaptureImport;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/**
 * @var yii\web\View $this
 * @var common\models\Device $model
 */

$this->title = Yii::t('gip', 'Import');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Import'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-import">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
	<div class="import-form">

	    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

	        'model' => $model,
	        'form' => $form,
	        'columns' => 1,
	        'attributes' => [

	            'file'=>['type'=> Form::INPUT_FILE, 'options'=>['placeholder'=>'Enter file name...', 'maxlength'=>160]],

	            'what'=>['type'=> Form::INPUT_RADIO_LIST, 'options'=> [
					'placeholder'=>'Enter items to upload...'],
					'value' => CaptureImport::TYPE_ALL,
					'items' => CaptureImport::getLocalizedConstants('TYPE_'),
					'label' => Yii::t('app', 'Import')
				],
	        ]

	    ]);

	    echo Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-primary']);
	    ActiveForm::end(); ?>

	</div>

</div>
