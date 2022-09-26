<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%executorStatuses}}`.
 */
class m220925_150733_create_executorStatuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%executorStatuses}}', [
            'id' => $this->primaryKey(),
            'executorStatus' => $this->string(255)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%executorStatuses}}');
    }
}
