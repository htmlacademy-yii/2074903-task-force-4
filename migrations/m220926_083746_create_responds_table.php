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
            'taskId' => $this->string(36)->notNull(),
            'executorId' => $this->string(36)->notNull(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'price' => $this->string(128)->notNull(),
            'comment' => $this->text()
        ]);

        $this->addForeignKey(
            'taskId',
            'responds',
            'taskId',
            'tasks',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'executorId',
            'responds',
            'executorId',
            'users',
            'uuid',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%responds}}');

        $this->dropForeignKey('taskId', 'responds');
        $this->dropForeignKey('executorId', 'responds');
    }
}
