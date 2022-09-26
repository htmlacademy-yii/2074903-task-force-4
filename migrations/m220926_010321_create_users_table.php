<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m220926_010321_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'uuid' => $this->string(36)->notNull()->unique(),
            'createAt' => $this->timestamp()
                ->defaultValue(new \yii\db\Expression('NOW()'))->notNull(),
            'email' => $this->string(128)->unique()->notNull(),
            'name' => $this->string(255)->notNull(),
            'password' => $this->char(255)->notNull(),
            'role' => $this->integer()->notNull(),
            'city' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('uuid', 'users', 'uuid');

        $this->addForeignKey(
            'role',
            'users',
            'role',
            'roles',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'city',
            'users',
            'city',
            'cities',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');

        $this->dropPrimaryKey('uuid', 'users');

        $this->dropForeignKey('role','users');
        $this->dropForeignKey('city', 'users');
    }
}
