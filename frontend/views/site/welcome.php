<?php
use frontend\widgets\Indicator;

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = 'GIP Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
	
            <div class="col-lg-12">
                <h2><?= Yii::t('gip', 'Dashboard Elements') ?></h2>


            </div>

        </div>

        <div class="row">

			<div class="col-md-3 col-sm-6 col-xs-12">
			<?= Indicator::widget([
					'item' => "I'm an indicator!",
					'icon' => 'fa-cog'
				  ]);
			?>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
			<?= Indicator::widget([
					'color' => 'red',
					'colorBG' => true,
					'icon' => 'fa-envelop-o',
					'progress' => 60,
					'progressDescription' => '62% done.'
				  ]);
			?>
			</div>

		</div>
		
    </div>

</div>
