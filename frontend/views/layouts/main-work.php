<?php
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use macgyer\yii2materializecss\widgets\Nav;
use macgyer\yii2materializecss\widgets\NavBar;
use macgyer\yii2materializecss\widgets\Breadcrumbs;

\macgyer\yii2materializecss\assets\MaterializeAsset::register($this);
$apphomedir = Yii::getAlias('@app');

$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('gip', 'Display Statuses'), 'url' => ['view', 'id' => 1]];
$this->params['breadcrumbs'][] = Yii::t('gip', 'Update');

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?= Yii::$app->homeUrl ?>favicon.ico">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="container">
	<?php
	$name = Yii::$app->name . (YII_ENV_DEV ? ' –DEV='.`cd $apphomedir ; git describe --tags` : '') . (YII_DEBUG ? '–DEBUG' : '') ;
	    NavBar::begin([
	    	'brandLabel' => $name,
	    	'brandUrl' => Yii::$app->homeUrl,
	    ]);

		$menu = [];
		if(Yii::$app->user->isGuest) {
			$menu[] = ['label' => 'Login', 'url' => ['/user/security/login']];
		} else {
			$user_menu = [];
			$user_menu[] = ['label' => Yii::t('store', 'Profile'), 'url' => ['/user/settings']];
			$user_menu[] = ['label' => Yii::t('store', 'Logout'), 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']];
			$menu[] = ['label' => Yii::$app->user->identity->username, 'items' => $user_menu];
		}

	echo Nav::widget([
	        'options' => [
				'class' => 'right',
			],
	        'items' => $menu
	    ]);          

	NavBar::end();
	?>

	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		'options' => [
			'class' => 'breadcrumb',
		]
	]) ?>
	<div class="content">
	<?= $content ?>
	</div>


	<footer class="page-footer">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Footer Content</h5>
					<p class="grey-text text-lighten-4"><small>
						<?php 	echo 'Version '.`cd $apphomedir ; git describe --tags`;
								if(YII_DEBUG) {
									echo ' — Last commit: '.`git log -1 --format=%cd --relative-date`;
									echo ' — '.`hostname`;
									echo ' — '.Yii::$app->getDb()->dsn;
								}
						?>
					</small></p>
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
			<?= Yii::$app->name.' &copy; '.date('Y') ?>
			<a class="grey-text text-lighten-4 right" href="#!">More Links</a>
			</div>
		</div>
	</footer>
	</div><!--.container-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>