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
            'taskId',
            'reviews',
            'taskId',
            'tasks',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'executorId',
            'reviews',
            'executorId',
            'users',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'clientId',
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
        $this->dropTable('{{%reviews}}');

        $this->dropForeignKey('taskId', 'reviews');
        $this->dropForeignKey('executorId', 'reviews');
        $this->dropForeignKey('clientId', 'reviews');
    }
}
