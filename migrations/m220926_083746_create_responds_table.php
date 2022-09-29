<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%responds}}`.
 */
class m220926_083746_create_responds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%responds}}', [
            'id' => $this->primaryKey(),
            'taskId' => $this->integer()->notNull(),
            'executorId' => $this->integer()->notNull(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'price' => $this->string(128)->notNull(),
            'comment' => $this->text()
        ]);

        $this->addForeignKey(
            'RESPOND_TASK_ID',
            'responds',
            'taskId',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'RESPOND_EXECUTOR_ID',
            'responds',
            'executorId',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('RESPOND_EXECUTOR_ID', 'responds');
        $this->dropForeignKey('RESPOND_TASK_ID', 'responds');

        $this->dropTable('{{%responds}}');
    }
}
