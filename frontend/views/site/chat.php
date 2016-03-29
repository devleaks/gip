<?php
use frontend\widgets\Indicator;

use jones\wschat\ChatWidget;

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = 'GIP Application';
?>
<div class="site-index">

    <div class="body-content">
		
        <div class="row">

		<?=ChatWidget::widget([
		    'auth' => false,
		    'port' => \console\controllers\ServerController::PORT,
//		    'user_id' => Yii::$app->user->id // setup id of current logged user
		]);?>

		</div>
    </div>

</div>
