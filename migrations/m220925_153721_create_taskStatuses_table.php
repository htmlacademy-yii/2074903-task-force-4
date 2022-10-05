<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%taskStatuses}}`.
 */
class m220925_153721_create_taskStatuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taskStatuses}}', [
            'id' => $this->primaryKey(),
            'taskStatus' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%taskStatuses}}');
    }
}
