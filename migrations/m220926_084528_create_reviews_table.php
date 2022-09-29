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
            'taskId' => $this->integer()->notNull(),
            'executorId' => $this->integer()->notNull(),
            'clientId' => $this->integer()->notNull(),
            'score' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull()
        ]);

        $this->addForeignKey(
            'REVIEW_TASK_ID',
            'reviews',
            'taskId',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'REVIEW_EXECUTOR_ID',
            'reviews',
            'executorId',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'REVIEW_CLIENT_ID',
            'reviews',
            'clientId',
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
        $this->dropForeignKey('REVIEW_CLIENT_ID', 'reviews');
        $this->dropForeignKey('REVIEW_EXECUTOR_ID', 'reviews');
        $this->dropForeignKey('REVIEW_TASK_ID', 'reviews');

        $this->dropTable('{{%reviews}}');
    }
}
