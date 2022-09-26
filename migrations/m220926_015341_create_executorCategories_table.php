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
            'executorId' => $this->string(36)->notNull()
        ]);

        $this->addForeignKey(
            'categoryId',
            'executorCategories',
            'categoryId',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'executorId',
            'executorCategories',
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
        $this->dropForeignKey('executorId', 'executorCategories');
        $this->dropForeignKey('categoryId', 'executorCategories');

        $this->dropTable('{{%executorCategories}}');
    }
}
