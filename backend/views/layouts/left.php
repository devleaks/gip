<?php

use common\models\User;
use common\models\League;

use yii\helpers\Url;

$display_role = Yii::$app->user->identity->role;

$items = [];

if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Engine',
        'icon' => 'fa fa-cog',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Devices', 'icon' => 'fa fa-plane', 'url' => ['/coreengine/device']],
			$subitems[] = ['label' => 'Device Groups', 'icon' => 'fa fa-truck', 'url' => ['/coreengine/device-group']],
			$subitems[] = ['label' => 'Zones', 'icon' => 'fa fa-square-o', 'url' => ['/coreengine/zone']],
			$subitems[] = ['label' => 'Zone Groups', 'icon' => 'fa fa-cog', 'url' => ['/coreengine/zone-group']],
			$subitems[] = ['label' => 'Display Statuses', 'icon' => 'fa fa-info', 'url' => ['/coreengine/display-status-type']],
			$subitems[] = ['label' => 'Notifications', 'icon' => 'fa fa-rss', 'url' => ['/coreengine/notification']],
			$subitems[] = ['label' => 'Notification Groups', 'icon' => 'fa fa-share-alt', 'url' => ['/coreengine/notification-group']],
			$subitems[] = ['label' => 'Services', 'icon' => 'fa fa-inbox', 'url' => ['/coreengine/service']],
			$subitems[] = ['label' => 'Rules', 'icon' => 'fa fa-gavel', 'url' => ['/coreengine/rule']],
			$subitems[] = ['label' => 'Subscriptions', 'icon' => 'fa fa-check-circle', 'url' => ['/coreengine/subscription']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Input',
        'icon' => 'fa fa-terminal',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Events', 'icon' => 'fa fa-list-ul', 'url' => ['/inputbroker/event']],
			$subitems[] = ['label' => 'Providers', 'icon' => 'fa fa-arrow-right', 'url' => ['/inputbroker/provider']],
			$subitems[] = ['label' => 'Processings', 'icon' => 'fa fa-cog', 'url' => ['/inputbroker/processing']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Viewer',
        'icon' => 'fa fa-eye',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Dashboards', 'icon' => 'fa fa-dashboard', 'url' => ['/viewer/dashboard']],
			$subitems[] = ['label' => 'GIPlets', 'icon' => 'fa fa-bar-chart', 'url' => ['/viewer/giplet']],
			$subitems[] = ['label' => 'Maps', 'icon' => 'fa fa-map', 'url' => ['/viewer/map']],
			$subitems[] = ['label' => 'Backgrounds', 'icon' => 'fa fa-globe', 'url' => ['/viewer/background']],
			$subitems[] = ['label' => 'Layers', 'icon' => 'fa fa-car', 'url' => ['/viewer/layer']],
			$subitems[] = ['label' => 'Tool Sets', 'icon' => 'fa fa-wrench', 'url' => ['/viewer/tool-group']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER, User::ROLE_INTERNAL])) {
	$items[] = [
        'label' => 'Developer',
        'icon' => 'fa fa-code',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Entity Types', 'icon' => 'fa fa-file-o', 'url' => ['/developer/type']],
			$subitems[] = ['label' => 'Styles', 'icon' => 'fa fa-pencil', 'url' => ['/developer/style']],
			$subitems[] = ['label' => 'Lists of Values', 'icon' => 'fa fa-list', 'url' => ['/developer/list-of-values']],
			$subitems[] = ['label' => 'Attribute Types', 'icon' => 'fa fa-font', 'url' => ['/developer/attribute-type']],
			$subitems[] = ['label' => 'Attributes', 'icon' => 'fa fa-font', 'url' => ['/developer/attribute']],
			$subitems[] = ['label' => 'Event Types', 'icon' => 'fa fa-file-o', 'url' => ['/developer/event-type']],
			$subitems[] = ['label' => 'Detection Types', 'icon' => 'fa fa-gavel', 'url' => ['/developer/detection-type']],
			$subitems[] = ['label' => 'Notification Types', 'icon' => 'fa fa-envelope', 'url' => ['/developer/notification-type']],
			$subitems[] = ['label' => 'Provider Types', 'icon' => 'fa fa-arrow-right', 'url' => ['/developer/provider-type']],
			$subitems[] = ['label' => 'Target Types', 'icon' => 'fa fa-arrow-left', 'url' => ['/developer/target-type']],
			$subitems[] = ['label' => 'Targets', 'icon' => 'fa fa-arrow-left', 'url' => ['/developer/target']],
			$subitems[] = ['label' => 'GIPlet Types', 'icon' => 'fa fa-bar-chart', 'url' => ['/developer/giplet-type']],
			$subitems[] = ['label' => 'Map Tools', 'icon' => 'fa fa-wrench', 'url' => ['/developer/tool']],
			$subitems[] = ['label' => 'Map Layer Types', 'icon' => 'fa fa-bar-chart', 'url' => ['/developer/layer-type']],
			$subitems[] = ['label' => 'Map Background Types', 'icon' => 'fa fa-globe', 'url' => ['/developer/background-type']],
			$subitems[] = ['label' => 'The Wire', 'icon' => 'fa fa-hashtag', 'url' => ['/developer/wire']],
			$subitems[] = ['label' => 'Dashboards', 'icon' => 'fa fa-dashboard', 'url' => ['/dashboard']],
		],
	];
}
if(in_array(Yii::$app->user->identity->role, [User::ROLE_ADMIN, User::ROLE_DEVELOPER, User::ROLE_INTERNAL])) {
	$subitems = [];
	if(Yii::$app->user->identity->isA([User::ROLE_ADMIN])) {
		$subitems[] = ['label' => 'User Accounts', 'icon' => 'fa fa-user', 'url' => ['/user/admin']];
		$subitems[] = ['label' => 'Backup', 'icon' => 'fa fa-download', 'url' => ['/admin/backup']];
	}
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
        	['label' => 'Frontend', 'icon' => 'fa fa-heart', 'url' => ['/../gip']],
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
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
