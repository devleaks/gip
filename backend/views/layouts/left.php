<?php

use common\models\User;
use common\models\League;

use yii\helpers\Url;

$display_role = Yii::$app->user->identity->role;

$items = [];

if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Engine',
        'icon' => 'cog',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Devices', 'icon' => 'plane', 'url' => ['/coreengine/device']],
			$subitems[] = ['label' => 'Device Groups', 'icon' => 'truck', 'url' => ['/coreengine/device-group']],
			$subitems[] = ['label' => 'Zones', 'icon' => 'square-o', 'url' => ['/coreengine/zone']],
			$subitems[] = ['label' => 'Zone Groups', 'icon' => 'cog', 'url' => ['/coreengine/zone-group']],
			$subitems[] = ['label' => 'Display Statuses', 'icon' => 'info', 'url' => ['/coreengine/display-status-type']],
			$subitems[] = ['label' => 'Notifications', 'icon' => 'rss', 'url' => ['/coreengine/notification']],
			$subitems[] = ['label' => 'Notification Groups', 'icon' => 'share-alt', 'url' => ['/coreengine/notification-group']],
			$subitems[] = ['label' => 'Services', 'icon' => 'inbox', 'url' => ['/coreengine/service']],
			$subitems[] = ['label' => 'Rules', 'icon' => 'gavel', 'url' => ['/coreengine/rule']],
			$subitems[] = ['label' => 'Subscriptions', 'icon' => 'check-circle', 'url' => ['/coreengine/subscription']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Input',
        'icon' => 'terminal',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Events', 'icon' => 'list-ul', 'url' => ['/inputbroker/event']],
			$subitems[] = ['label' => 'Providers', 'icon' => 'arrow-right', 'url' => ['/inputbroker/provider']],
			$subitems[] = ['label' => 'Processings', 'icon' => 'cog', 'url' => ['/inputbroker/processing']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER])) {
	$items[] = [
        'label' => 'Viewer',
        'icon' => 'eye',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Dashboards', 'icon' => 'dashboard', 'url' => ['/viewer/dashboard']],
			$subitems[] = ['label' => 'GIPlets', 'icon' => 'bar-chart', 'url' => ['/viewer/giplet']],
			$subitems[] = ['label' => 'Maps', 'icon' => 'map', 'url' => ['/viewer/map']],
			$subitems[] = ['label' => 'Map Layers', 'icon' => 'globe', 'url' => ['/viewer/layer']],
			$subitems[] = ['label' => 'Map Tools', 'icon' => 'wrench', 'url' => ['/viewer/tool-group']],
		],
	];
}
if(Yii::$app->user->identity->isA([User::ROLE_ADMIN, User::ROLE_DEVELOPER, User::ROLE_INTERNAL])) {
	$items[] = [
        'label' => 'Developer',
        'icon' => 'code',
        'url' => '#',
        'items' => [
			$subitems[] = ['label' => 'Entity Types', 'icon' => 'file-o', 'url' => ['/developer/type']],
			$subitems[] = ['label' => 'Styles', 'icon' => 'pencil', 'url' => ['/developer/style']],
			$subitems[] = ['label' => 'Lists of Values', 'icon' => 'list', 'url' => ['/developer/list-of-values']],
			$subitems[] = ['label' => 'Attribute Types', 'icon' => 'font', 'url' => ['/developer/attribute-type']],
			$subitems[] = ['label' => 'Attributes', 'icon' => 'font', 'url' => ['/developer/attribute']],
			$subitems[] = ['label' => 'Event Types', 'icon' => 'file-o', 'url' => ['/developer/event-type']],
			$subitems[] = ['label' => 'Detection Types', 'icon' => 'gavel', 'url' => ['/developer/detection-type']],
			$subitems[] = ['label' => 'Notification Types', 'icon' => 'envelope', 'url' => ['/developer/notification-type']],
			$subitems[] = ['label' => 'Provider Types', 'icon' => 'arrow-right', 'url' => ['/developer/provider-type']],
			$subitems[] = ['label' => 'Target Types', 'icon' => 'arrow-left', 'url' => ['/developer/target-type']],
			$subitems[] = ['label' => 'Targets', 'icon' => 'arrow-left', 'url' => ['/developer/target']],
			$subitems[] = ['label' => 'GIPlet Types', 'icon' => 'bar-chart', 'url' => ['/developer/giplet-type']],
			$subitems[] = ['label' => 'Map Layer Types', 'icon' => 'map', 'url' => ['/developer/layer-type']],
			$subitems[] = ['label' => 'Map Tools', 'icon' => 'wrench', 'url' => ['/developer/tool']],
			$subitems[] = ['label' => 'Zone Editor', 'icon' => 'globe', 'url' => ['/developer/zone-editor']],
			$subitems[] = ['label' => 'The Wire', 'icon' => 'hashtag', 'url' => ['/developer/wire']],
			$subitems[] = ['label' => 'Dashboards', 'icon' => 'dashboard', 'url' => ['/dashboard']],
		],
	];
}
if(in_array(Yii::$app->user->identity->role, [User::ROLE_ADMIN, User::ROLE_DEVELOPER, User::ROLE_INTERNAL])) {
	$subitems = [];
	if(Yii::$app->user->identity->isA([User::ROLE_ADMIN])) {
		$subitems[] = ['label' => 'User Accounts', 'icon' => 'user', 'url' => ['/user/admin']];
		$subitems[] = ['label' => 'Backup', 'icon' => 'download', 'url' => ['/admin/backup']];
	}
	$items[] = [
        'label' => 'Site',
        'icon' => 'dashboard',
        'url' => '#',
        'items' => $subitems,
	];
}
if(defined('YII_DEBUG')) {
	$items[] = [
        'label' => 'Development',
        'icon' => 'cog',
        'url' => '#',
        'items' => [
            // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
        	['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug']],
            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
        	['label' => 'Frontend', 'icon' => 'heart', 'url' => ['/../gip']],
        	['label' => 'Documentation', 'icon' => 'support', 'url' => ['/../gip/doc/guide-README.html']],
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
