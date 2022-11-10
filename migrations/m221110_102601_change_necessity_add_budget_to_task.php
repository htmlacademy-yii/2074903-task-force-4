<?php

use yii\db\Migration;

/**
 * Class m221110_102601_change_necessity_add_budget_to_task
 */
class m221110_102601_change_necessity_add_budget_to_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'budget', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
