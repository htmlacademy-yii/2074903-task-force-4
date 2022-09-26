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
            'uuid' => $this->string(36)->notNull(),
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

        $this->addPrimaryKey('uuid', 'tasks', 'uuid');

        $this->addForeignKey(
            'categoryId',
            'tasks',
            'categoryId',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'status',
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
        $this->dropTable('{{%tasks}}');

        $this->dropPrimaryKey('uuid', 'tasks');

        $this->dropForeignKey('categoryId', 'tasks');
        $this->dropForeignKey('status', 'tasks');

        $this->dropIndex('t_name', 'tasks');
    }
}
