<?php

use yii\db\Migration;

/**
 * Class m221019_152233_change_price_to_default_null
 */
class m221019_152233_change_price_to_default_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('responds', 'price', 'integer default null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('responds', 'price', 'integer not null');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221019_152233_change_price_to_default_null cannot be reverted.\n";

        return false;
    }
    */
}
