<?php

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/config/common.php'),
    require(__DIR__ . '/config/console.php')
);

//FIXME костыль. Для работы WebSocketServer $ws_server нужен экземпляр приложения.
//почему костыль, потому что по уму надо запускать файл yii, и все делать через yii-шные консольные контролеры,
//но для этого надо адаптировать библиотеку walkor/Workerman, потому что в ней уже реализована своя работа с консолью
//в итоге после долгих попыток, решил оставить пока так. Этот файл server.php запускает WebSocket сервер
$app = new yii\console\Application($config);


/** @var \app\ext\WebSocketServer $ws_server */
$ws_server = $app->get('ws');
$ws_server->runWorkers();

//exit($exitCode);