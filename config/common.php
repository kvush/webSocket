<?php
$port = "8000";

return [
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:@app/database.sqlite',
        ],
        'ws' => function() use ($port) {
            return new app\ext\WebSocketServer($port);
        },
    ],
];