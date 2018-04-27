<?php
namespace app\ext;


use app\models\Client;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;


/**
 * Class WebSocketServer2
 *
 * @package app\ext
 */
class WebSocketServer extends Worker
{
    /**
     * Construct.
     *
     * @param string $port
     */
    public function __construct($port)
    {
        parent::__construct("websocket://0.0.0.0:$port");
        $this->name = 'SKU WebSocket';

        $this->callbackInit();
    }

    /**
     * Инициализация калбэков
     */
    private function callbackInit()
    {
        $this->onWorkerStart = function($worker)
        {
            //todo: перенести очистку в событие onWorkerStop
            Client::clearAllData();
        };

        $this->onConnect = function($connection)
        {
            // Emitted when websocket handshake done
            $connection->onWebSocketConnect = function($connection)
            {
                echo "New connection\n";
            };
        };

        // Emitted when data is received
        $this->onMessage = function($connection, $data)
        {
            echo "New message: $data\n";
            echo "ConnID:".$connection->id."\n";

            $dataArr = json_decode($data, true);
            if (Client::initNewConnection($connection->id, $dataArr['clientId'], $dataArr['taskId'])){
                /** @var TcpConnection $connection */
                $connection->send('Your data '. $data .' was saved');
            }
            else {
                /** @var TcpConnection $connection */
                $connection->send('Got error while saving data');
            }
        };

        //fixme, проверить. Вроле событие не вызываются если ctrl+c в консоле.
        $this->onWorkerStop = function($worker)
        {
            Client::clearAllData();
            echo "Worker stop";
        };

        //fixme, проверить. Вроле событие не вызываются если ctrl+c в консоле.
        $this->onError = function($connection, $code, $msg)
        {
            Client::clearAllData();
            echo "error $code $msg\n";
        };
    }

    /**
     * Запуск всех воркеров
     */
    public function runWorkers() {
        Worker::runAll();
    }
}