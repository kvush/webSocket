<?php

use yii\db\Migration;

/**
 * Class m180427_100833_init
 */
class m180427_100833_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'connId' => $this->string(10)->notNull(),
            'clientId' => $this->string(10)->notNull(),
            'taskId' => $this->string(10)->notNull()
        ], null);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
