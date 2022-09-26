<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%userTasks}}`.
 */
class m220926_022631_create_userTasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%userTasks}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->string(36)->notNull(),
            'taskId' => $this->string(36)->notNull()
        ]);

        $this->addForeignKey(
            'TASK_USER_ID',
            'userTasks',
            'userId',
            'users',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'USER_TASK_ID',
            'userTasks',
            'taskId',
            'tasks',
            'uuid',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('USER_TASK_ID', 'userTasks');
        $this->dropForeignKey('TASK_USER_ID', 'userTasks');

        $this->dropTable('{{%userTasks}}');
    }
}
