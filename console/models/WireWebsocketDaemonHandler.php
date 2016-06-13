<?php

namespace console\models;

//пример реализации чата
class WireWebsocketDaemonHandler extends \morozovsk\websocket\Daemon
{
    protected function onOpen($connectionId, $info) {
    }

    protected function onClose($connectionId) {
    }

    protected function onMessage($connectionId, $data, $type) {
        if (!strlen($data)) {
            return;
        }

        $message = 'user #' . $connectionId . ' (' . $this->pid . '): ' . strip_tags($data);
		echo substr($message, 0, 60) . PHP_EOL;

        foreach ($this->clients as $clientId => $client) {
            $this->sendToClient($clientId, $data);
        }
    }
}