<?php

/* @var $this \yii\web\View */
/* @var $content string */

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Nav;
use macgyer\yii2materializecss\widgets\NavBar;
use macgyer\yii2materializecss\widgets\Breadcrumbs;
use macgyer\yii2materializecss\widgets\Alert;

frontend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
		<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

        <header class="page-header">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'fixed' => true,
                'wrapperOptions' => [
                    'class' => 'container'
                ],
            ]);

            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = '<li>'
                    . Html::a(
                        'Sign out',
                        ['/user/security/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                    ) . '</li>';
            }

            echo Nav::widget([
                'options' => ['class' => 'right'],
                'items' => $menuItems,
            ]);

            NavBar::end();
            ?>
        </header>

        <main class="content">
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <?= Alert::widget() ?>
				<?php
				$js = <<<JS
$('#chat-form').submit(function() {

     var form = $(this);

     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
               $("#message-field").val("");
          }
     });

     return false;
});
JS;
				$this->registerJs($js, \yii\web\View::POS_READY);		
				?>
				<div class="row">
		            <div class="card col-lg-8 col-lg-offset-2">

		                <?= Html::beginForm(['/site/index'], 'POST', [
		                    'id' => 'chat-form'
		                ]) ?>

		                <div class="row">
		                    <div class="col-xs-3">
		                        <div class="form-group">
		                            <?= Html::textInput('name', null, [
		                                'class' => 'form-control',
		                                'placeholder' => 'Name'
		                            ]) ?>
		                        </div>
		                    </div>
		                    <div class="col-xs-7">
		                        <div class="form-group">
		                            <?= Html::textInput('message', null, [
		                                'id' => 'message-field',
		                                'class' => 'form-control',
		                                'placeholder' => 'Message'
		                            ]) ?>
		                        </div>
		                    </div>
		                    <div class="col-xs-2">
		                        <div class="form-group">
		                            <?= Html::submitButton('Send', [
		                                'class' => 'btn btn-block btn-success'
		                            ]) ?>
		                        </div>
		                    </div>
		                </div>

		                <?= Html::endForm() ?>

		                <div id="notifications" ></div>
		            </div>
		        </div>


                <?= $content ?>
            </div>
        </main>

        <footer class="page-footer">
            <div class="container">
                <div class="row">
	                <div class="col l6 s12">
	                    <h5 class="white-text">Version Information</h5>
	                    <p class="grey-text text-lighten-4"><?php $apphomedir = Yii::getAlias('@common'); echo ' — Version '.`cd $apphomedir/.. ; git describe --tags`;
							if(YII_DEBUG) {
								echo ' — Last commit: '.`git log -1 --format=%cd --relative-date`;
								echo ' — '.`hostname`;
								echo ' — '.Yii::$app->getDb()->dsn;
							}
						?></p>
	                </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Links</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <?= Yii::$app->name.' &copy; '.date('Y').' • '.Yii::powered() ?>
                </div>
            </div>
        </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>