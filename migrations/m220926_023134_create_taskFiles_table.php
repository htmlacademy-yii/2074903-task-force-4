<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%taskFiles}}`.
 */
class m220926_023134_create_taskFiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taskFiles}}', [
            'id' => $this->primaryKey(),
            'fileId' => $this->integer()->notNull(),
            'taskId' => $this->string(36)->notNull()
        ]);

        $this->addForeignKey(
            'fileId',
            'taskFiles',
            'fileId',
            'files',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'taskId',
            'taskFiles',
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
        $this->dropTable('{{%taskFiles}}');

        $this->dropForeignKey('fileId', 'taskFiles');
        $this->dropForeignKey('taskId', 'taskFiles');
    }
}
