<?php

use yii\db\Migration;

/**
 * Class m221028_014945_add_vkId_to_users
 */
class m221028_014945_add_vkId_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'vkId', $this->integer()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'vkId');
    }
}
