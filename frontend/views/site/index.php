<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Geo Intelligent Platform';
?>
<div class="site-index">


    <div class="jumbotron">

        <h1>Welcome!</h1>

        <p class="lead">Welcome to Your GIP Account.</p>

        <p><a class="btn btn-lg btn-danger" href="<?= Url::to(['/user/login']) ?>">Get started with Your GIP Application</a></p>

		<img src="/gip/images/welcome.png" class="center" />

    </div>

    <div class="body-content">
	
        <div class="row">
            <div class="col-lg-6">
                <h2>Menus for Visitors</h2>

                <ul>
                    <li><a href="<?= Url::to(['/gip']) ?>">GIP</a></li>
                </ul>

            </div>

        </div>

    </div>

</div>
