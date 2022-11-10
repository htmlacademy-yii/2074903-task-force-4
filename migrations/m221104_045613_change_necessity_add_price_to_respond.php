<?php

use yii\db\Migration;

/**
 * Class m221104_045613_change_necessity_add_price_to_respond
 */
class m221104_045613_change_necessity_add_price_to_respond extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('responds', 'price', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
