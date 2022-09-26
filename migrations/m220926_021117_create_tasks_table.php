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
            'uuid' => $this->string(36)->notNull()->unique(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'expiryDate' => $this->timestamp()->notNull(),
            'budget' => $this->string(128)->notNull(),
            'categoryId' => $this->integer()->notNull(),
            'lat' => $this->decimal(9,7),
            'lng' => $this->decimal(10,7),
            'status' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('TASK_UUID', 'tasks', 'uuid');

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

        $this->createIndex('t_name', 'tasks', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('t_name', 'tasks');

        $this->dropForeignKey('TASK_STATUS', 'tasks');
        $this->dropForeignKey('TASK_CATEGORY_ID', 'tasks');

        $this->dropPrimaryKey('TASK_UUID', 'tasks');

        $this->dropTable('{{%tasks}}');
    }
}
