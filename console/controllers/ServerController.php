<?php

namespace console\controllers;

use common\models\User;

use Yii;
use jones\wschat\components\Chat;
use jones\wschat\components\ChatManager;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerController extends \yii\console\Controller
{
	const PORT = 8081;
	
    public function actionRun()
    {
        $server = IoServer::factory(new HttpServer(new WsServer(new Chat(new ChatManager(['userClassName' => User::className()])))), self::PORT);
        echo 'Starting server ...'.PHP_EOL;
        $server->run();
        echo 'Server was started successfully. Setup logging to get more details.'.PHP_EOL;
    }
}