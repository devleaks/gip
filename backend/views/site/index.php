<?php

use devleaks\weather\Weather;

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'GIP - Administration';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome!</h1>

        <p class="lead">Welcome to <?= Yii::$app->name ?>.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/']) ?>">Get started with <?= Yii::$app->name ?>!</a></p>
    </div>

    <div class="body-content">

        <div class="row">
	
            <div class="col-lg-2 col-lg-offset-3">
                <h3>Input</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/inputbroker/provider']) ?>">Provider</a></li>
                    <li>&raquo; <a href="<?= Url::to(['/developer/target']) ?>">Target</a></li>
                    <li>&raquo; <a href="<?= Url::to(['/inputbroker/processing']) ?>">Processing</a></li>
                </ul>

            </div>

            <div class="col-lg-2">
                <h3>Processing</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/coreengine/device']) ?>">Device</a></li>
                    <li>&raquo; <a href="<?= Url::to(['/coreengine/zone']) ?>">Zone</a></li>
                    <li>&raquo; <a href="<?= Url::to(['/coreengine/rule']) ?>">Rules</a></li>
				</ul>
            </div>

            <div class="col-lg-2">
                <h3>Views</h3>

				<ul style="list-style: none;padding-left:0;">
                    <li>&raquo; <a href="<?= Url::to(['/viewer/dashboard']) ?>">Dashboards</a></li>
                    <li>&raquo; <a href="<?= Url::to(['/viewer/map']) ?>">Maps</a></li>
				</ul>
            </div>
        </div>

		<hr />

        <div class="row">
	
            <div class="col-lg-6 col-lg-offset-3">
				<?php   echo '<div id="weather"></div>';
						if(isset(Yii::$app->params['FORECAST_APIKEY'])) {
							echo Weather::widget([
								'id' => 'weather',
								'pluginOptions' => [
									'celsius' => true,
									'cacheTime' => 60,
									'key' => Yii::$app->params['FORECAST_APIKEY'],
									'lat' => Yii::$app->params['FORECAST_DEFAULT_LAT'],
									'lon' => Yii::$app->params['FORECAST_DEFAULT_LON'],
								]
							]);
						} else {
							Yii::$app->session->setFlash('error', 'Weather: No API key.');
						}
				?>
            </div>
		</div>
    </div>
</div>
