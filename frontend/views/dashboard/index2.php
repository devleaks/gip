<?php

use frontend\widgets\RandomChart;
use frontend\widgets\Indicator;
use frontend\widgets\Metar;

use fedemotta\gridstack\Gridstack;

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'GIP Application Dashboard';
?>
<div class="site-welcome body-content">

<?= RandomChart::widget(); ?>

</div><!-- .site-welcome -->
