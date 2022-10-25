<?php

use yii\db\Migration;

/**
 * Class m221025_132742_divide_task_location_to_city_and_address
 */
class m221025_132742_divide_task_location_to_city_and_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('tasks', 'location');
        $this->addColumn('tasks', 'city', $this->string(255));
        $this->addColumn('tasks', 'address', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'address');
        $this->dropColumn('tasks', 'city');
        $this->addColumn('tasks', 'location', $this->string(255));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221025_132742_divide_task_location_to_city_and_address cannot be reverted.\n";

        return false;
    }
    */
}
