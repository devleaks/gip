<?php

use backend\assets\DashboardAsset;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Dashboard $searchModel
 */

$this->title = $model->display_name;

DashboardAsset::register($this);

?>
<div class="viewer-dashboard">
	<?= $model->layout ?>
</div>
<script type="text/javascript">
<?php $this->beginBlock('JS_DASHBOARD_RENDER') ?>
<?php $this->endBlock(); ?>
</script>
<?php
$this->registerJs($this->blocks['JS_DASHBOARD_RENDER'], yii\web\View::POS_READY);
