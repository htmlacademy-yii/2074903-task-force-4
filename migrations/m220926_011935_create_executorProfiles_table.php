<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%executorProfiles}}`.
 */
class m220926_011935_create_executorProfiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%executorProfiles}}', [
            'executorId' => $this->string(36)->notNull(),
            'avatarSrc' => $this->string(255),
            'birthDate' => $this->timestamp(),
            'phone' => $this->char(255),
            'telegram' => $this->string(255),
            'bio' => $this->text(),
            'status' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('executorId', 'executorProfiles', 'executorId');

        $this->addForeignKey(
            'executorId',
            'executorProfiles',
            'executorId',
            'users',
            'uuid',
            'CASCADE'
        );

        $this->addForeignKey(
            'status',
            'executorProfiles',
            'status',
            'executorStatuses',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%executorProfiles}}');

        $this->dropPrimaryKey('executorId', 'executorProfiles');

        $this->dropForeignKey('executorId', 'executorProfiles');
        $this->dropForeignKey('status', 'executorProfiles');
    }
}
