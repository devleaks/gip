<?php

use backend\models\CaptureImport;

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/**
 * @var yii\web\View $this
 * @var common\models\Device $model
 */

$this->title = Yii::t('gip', 'Import Feedback');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Import'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-import">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
	<div class="import-form">

	    <?= print_r($model->attributes) ?>
	    <?= $content ?>

		<p>
		<?= Html::a('<i class="glyphicon glyphicon-list"></i> Index', ['index'], ['class' => 'btn btn-success']) ?>
		</p>
	</div>

</div>
