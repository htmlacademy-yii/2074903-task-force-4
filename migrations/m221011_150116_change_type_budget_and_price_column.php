<?php

use yii\db\Migration;

/**
 * Class m221011_150116_change_type_budget_and_price_column
 */
class m221011_150116_change_type_budget_and_price_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'budget', 'integer not null');
        $this->alterColumn('responds', 'price', 'integer not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('responds', 'price', 'string not null');
        $this->alterColumn('tasks', 'budget', 'string not null');
    }
}
