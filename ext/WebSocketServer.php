<?php
namespace app\ext;


use app\models\Client;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;
use yii\helpers\Json;


/**
 * Class WebSocketServer2
 *
 * @package app\ext
 */
class WebSocketServer extends Worker
{
    const LOCAL_SOCKET = 'tcp://127.0.0.1:1234';

    /** @var TcpConnection[]  */
    private $users = [];

    /**
     * Number of worker processes.
     *
     * @var int
     */
    public $count = 1; //??? нужно ли больше

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

            $inner_tcp_worker = new Worker(self::LOCAL_SOCKET);
            $inner_tcp_worker->onMessage = function($connection, $data) {
                // you have to use json_decode for $data because send.php uses json_encode
                $data = json_decode($data, true); // but you can use another protocol for send data send.php to local tcp-server
                $connIds = $data['connId'];
                foreach ($connIds as $connId) {
                    // send a message to the user by userId
                    if (isset($this->users[$connId])) {
                        $webconnection = $this->users[$connId];
                        $webconnection->send($data['message']);
                    }
                }

            };
            $inner_tcp_worker->listen();
        };

        $this->onConnect = function($connection)
        {
            // Emitted when websocket handshake done
            $connection->onWebSocketConnect = function($connection)
            {
                echo "New connection ConnId: $connection->id\n";
                $this->users[$connection->id] = $connection;
            };
        };

        // Emitted when data is received
        $this->onMessage = function($connection, $data)
        {
            echo "New message: $data\n";
            echo "ConnId:".$connection->id."\n";

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

        $this->onClose = function($connection)
        {
            if(isset($this->user[$connection->id])) {
                // unset parameter when user is disconnected
                unset($this->user[$connection->id]);
            }
            Client::clearOneData($connection->id);
            echo "connection closed\n";
        };

        //fixme, проверить. Вроде событие не вызываются если ctrl+c в консоле.
        $this->onWorkerStop = function($worker)
        {
            Client::clearAllData();
            echo "Worker stop";
        };

        $this->onError = function($connection, $code, $msg)
        {
            echo "error $code $msg\n";
        };
    }

    /**
     * Запуск всех воркеров
     */
    public function runWorkers() {
        Worker::runAll();
    }

    /**
     * @param $connId
     * @param $message
     *
     * @return bool
     */
    public function sendMessage($connId, $message)
    {
        // connect to a local tcp-server
        $instance = stream_socket_client(self::LOCAL_SOCKET);
        if (!$instance) {
            return false;
        }
        $string = JSON::encode(['connId' => $connId, 'message' => $message])  . "\n";
        // send message
        fwrite($instance, $string);
        return true;
    }
}