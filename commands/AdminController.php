<?php
namespace app\commands;


use app\ext\WebSocketServer;
use app\models\Client;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

/**
 * Консольный клиент по мониторингу подключенных клиентов и отсылки им сообщений
 *
 * @package app\commands
 */
class AdminController extends Controller
{

    /** @var  string */
    public $userId;
    /** @var  string */
    public $message;

    /**
     * @param string $actionID
     *
     * @return array
     */
    public function options($actionID)
    {
        return ['userId', 'message'];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return ['u' => 'userId', 'm' => 'message'];
    }

    /**
     * Получаем всех зарегестрированных пользователей
     * @return int
     */
    public function actionGetAllUsers()
    {
        /** @var Client[] $clients */
        $clients = Client::find()->all();

        if (empty($clients)) {
            echo 'Пользователей нет';
            return ExitCode::OK;
        }

        $result = '';
        foreach ($clients as $client) {
            $result .= "client ID: $client->clientId; ";
            $result .= "task ID: $client->taskId;\n";
        }
        echo $result;
        return ExitCode::OK;
    }

    /**
     * Получаем все задачи для $userId
     * @return int
     */
    public function actionGetAllUserTask()
    {
        if (empty($this->userId)) {
            echo "укажите через ключ -u необходимый clientId";
            return ExitCode::OK;
        }

        /** @var Client[] $clients */
        $clients = Client::findAll(['clientId' => $this->userId]);

        if (empty($clients)) {
            echo 'Пользователей нет';
            return ExitCode::OK;
        }

        $result = '';
        foreach ($clients as $client) {
            $result .= "task ID: $client->taskId;\n";
        }
        echo $result;
        return ExitCode::OK;
    }

    /**
     * Отправляем сообщение пользователям
     *
     * @return int
     */
    public function actionSendMessage()
    {
        if (empty($this->userId)) {
            echo "укажите через ключ -u необходимый clientId или -u all для отправки сообщения всем пользователям";
            return ExitCode::OK;
        }

        if (empty($this->message)) {
            echo "укажите через ключ -m текст сообщения";
            return ExitCode::OK;
        }

        if ($this->userId == 'all') {
            $connId = Client::find()->select('connId')->asArray()->all();
        }
        else {
            $connId = Client::find()->select('connId')
                ->where(['clientId' => $this->userId])->asArray()->all();
        }

        $connId = ArrayHelper::getColumn($connId, 'connId');

        if (empty($connId)) {
            echo "Пользователий с clientId: " . $this->userId . ", не найдено";
            return ExitCode::OK;
        }

        /** @var WebSocketServer $ws */
        $ws = \Yii::$app->get('ws');
        if ($ws->sendMessage($connId, $this->message)){
            echo "Ваше сообщение: ";
            echo $this->message;
            echo "\nуспешно отправлено";
        }
        else {
            echo "Произошла ошибка\n";
        }

        return ExitCode::OK;
    }
}
