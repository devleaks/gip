<?php

use common\models\User;
use common\models\League;

use yii\helpers\Url;

$display_role = Yii::$app->user->identity->role;

$items = [];

if(Yii::$app->user->identity->isA([User::ROLE_ADMIN])) {
	$subitems = [];
	$subitems[] = ['label' => 'Welcome', 'icon' => 'fa fa-dashboard', 'url' => ['/site/index']];
	$items[] = [
        'label' => 'Create',
        'icon' => 'fa fa-list',
        'url' => '#',
        'items' => $subitems,
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN])) {
	$items[] = [
        'label' => 'Prepare',
        'icon' => 'fa fa-pencil-square',
        'url' => '#',
        'items' => [
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN])) {
	$items[] = [
        'label' => 'Report',
        'icon' => 'fa fa-server',
        'url' => '#',
        'items' => [
		],
	];
}
if(in_array(Yii::$app->user->identity->role, [User::ROLE_ADMIN])) {
	$subitems = [];
	$subitems[] = ['label' => 'My Profile', 'icon' => 'fa fa-user', 'url' => ['/user/settings']];
	$items[] = [
        'label' => 'Site',
        'icon' => 'fa fa-dashboard',
        'url' => '#',
        'items' => $subitems,
	];
}
if(defined('YII_DEBUG')) {
	$items[] = [
        'label' => 'Development',
        'icon' => 'fa fa-cog',
        'url' => '#',
        'items' => [
            // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
        	['label' => 'Debug', 'icon' => 'fa fa-bug', 'url' => ['/debug']],
            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
        	['label' => 'Backend', 'icon' => 'fa fa-heart', 'url' => ['/../gipadmin']],
        	['label' => 'Documentation', 'icon' => 'fa fa-support', 'url' => ['/../gip/doc/guide-README.html']],
            // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
		],
	];
}

?><aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->user->identity->getProfilePicture() ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online - <?= $display_role ?></a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?= Url::to(['/site/search']) ?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <!-- /.search form -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => [
					'class' => 'sidebar-menu',
				    'data-widget' => 'tree'
				],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
