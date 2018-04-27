<?php
namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $connId
 * @property string $clientId
 * @property string $taskId
 */
class Client extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @param $connId
     * @param $clientId
     * @param $taskId
     *
     * @return bool
     */
    public static function initNewConnection($connId, $clientId, $taskId)
    {
        $find = self::findOne(['connId' => $connId]);
        if ($find) {
            $find->clientId = $clientId;
            $find->taskId = $taskId;
            return $find->save();
        }
        $new = new self();
        $new->connId = $connId;
        $new->clientId = $clientId;
        $new->taskId = $taskId;
        return $new->save();
    }

    /**
     * Удаляем все записи
     */
    public static function clearAllData()
    {
        Client::deleteAll();
    }

}