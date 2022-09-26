<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m220926_084528_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'taskId' => $this->string(36)->notNull(),
            'executorId' => $this->string(36)->notNull(),
            'clientId' => $this->string(36)->notNull(),
            'score' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'success' => $this->boolean(),
        ]);

        $this->addForeignKey(
            'REVIEW_TASK_ID',
            'reviews',
            'taskId',
            'tasks',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'REVIEW_EXECUTOR_ID',
            'reviews',
            'executorId',
            'users',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'REVIEW_CLIENT_ID',
            'reviews',
            'clientId',
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
        $this->dropForeignKey('REVIEW_CLIENT_ID', 'reviews');
        $this->dropForeignKey('REVIEW_EXECUTOR_ID', 'reviews');
        $this->dropForeignKey('REVIEW_TASK_ID', 'reviews');

        $this->dropTable('{{%reviews}}');
    }
}
