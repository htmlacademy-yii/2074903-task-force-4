<?php

use yii\db\Migration;

/**
 * Class m221011_152648_add_default_null_expiryDate
 */
class m221011_152648_add_default_null_expiryDate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'expiryDate', 'timestamp default null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks', 'expiryDate', 'timestamp not null');
    }
}
