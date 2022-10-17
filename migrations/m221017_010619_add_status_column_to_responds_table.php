<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%responds}}`.
 */
class m221017_010619_add_status_column_to_responds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('responds', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('responds', 'status');
    }
}
