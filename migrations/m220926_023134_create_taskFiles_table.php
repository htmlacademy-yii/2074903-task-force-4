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
            'TASK_FILE_ID',
            'taskFiles',
            'fileId',
            'files',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'FILE_TASK_ID',
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
        $this->dropForeignKey('FILE_TASK_ID', 'taskFiles');
        $this->dropForeignKey('TASK_FILE_ID', 'taskFiles');

        $this->dropTable('{{%taskFiles}}');
    }
}
