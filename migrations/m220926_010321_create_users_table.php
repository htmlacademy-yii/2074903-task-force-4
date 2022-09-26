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

        $this->addPrimaryKey('USER_UUID', 'users', 'uuid');

        $this->addForeignKey(
            'USER_ROLE',
            'users',
            'role',
            'roles',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'USER_CITY',
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
        $this->dropForeignKey('USER_CITY', 'users');
        $this->dropForeignKey('USER_ROLE','users');

        $this->dropPrimaryKey('USER_UUID', 'users');

        $this->dropTable('{{%users}}');
    }
}