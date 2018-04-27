<?php
namespace app\commands;

use app\ext\WebSocketServer;
use yii\console\Controller;

/**
 * Class ServerController
 *
 * @package app\commands
 * TODO: пока что выходит что не нужен
 */
class ServerController extends Controller
{
    /**
     * @param $command
     * TODO: тут, по уму должен запускаться websocket сервер. Пока что используем файлик server.php в корне.
     */
    public function actionStart($command)
    {
        /** @var WebSocketServer $ws_server */
        $ws_server = \Yii::$app->get('ws');
        $ws_server->runWorkers();
    }
}
