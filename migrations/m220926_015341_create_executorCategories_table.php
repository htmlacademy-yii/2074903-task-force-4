<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%executorCategories}}`.
 */
class m220926_015341_create_executorCategories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%executorCategories}}', [
            'id' => $this->primaryKey(),
            'categoryId' => $this->integer()->notNull(),
            'executorId' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'EXECUTOR_CATEGORY_ID',
            'executorCategories',
            'categoryId',
            'categories',
            'id'
        );

        $this->addForeignKey(
            'CATEGORY_EXECUTOR_ID',
            'executorCategories',
            'executorId',
            'users',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('CATEGORY_EXECUTOR_ID', 'executorCategories');
        $this->dropForeignKey('EXECUTOR_CATEGORY_ID', 'executorCategories');

        $this->dropTable('{{%executorCategories}}');
    }
}
