<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%respondStatuses}}`.
 */
class m221017_010415_create_respondStatuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%respondStatuses}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string(255)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%respondStatuses}}');
    }
}
