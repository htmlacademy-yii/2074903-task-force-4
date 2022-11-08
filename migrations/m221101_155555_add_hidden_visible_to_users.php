<?php

use yii\db\Migration;

/**
 * Class m221101_155555_add_hidden_visible_to_users
 */
class m221101_155555_add_hidden_visible_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'hidden', $this->boolean());
        $this->alterColumn('users', 'telegram', $this->string(64));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'telegram', $this->string(30));
        $this->dropColumn('users', 'hidden');
    }
}
