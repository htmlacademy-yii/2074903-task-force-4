<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m220926_021117_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'expiryDate' => $this->timestamp()->notNull(),
            'budget' => $this->string(128)->notNull(),
            'categoryId' => $this->integer()->notNull(),
            'cityId' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'executorId' => $this->integer(),
            'clientId' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'TASK_CATEGORY_ID',
            'tasks',
            'categoryId',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'TASK_STATUS',
            'tasks',
            'status',
            'taskStatuses',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'TASK_EXECUTOR_ID',
            'tasks',
            'executorId',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'TASK_CLIENT_ID',
            'tasks',
            'clientId',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'TASK_CITY_ID',
            'tasks',
            'cityId',
            'cities',
            'id',
            'CASCADE'
        );

        $this->createIndex('t_name', 'tasks', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('t_name', 'tasks');

        $this->dropForeignKey('TASK_CITY_ID', 'tasks');
        $this->dropForeignKey('TASK_CLIENT_ID', 'tasks');
        $this->dropForeignKey('TASK_EXECUTOR_ID', 'tasks');
        $this->dropForeignKey('TASK_STATUS', 'tasks');
        $this->dropForeignKey('TASK_CATEGORY_ID', 'tasks');

        $this->dropTable('{{%tasks}}');
    }
}
