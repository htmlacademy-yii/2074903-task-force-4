<?php

use yii\db\Migration;

/**
 * Class m220929_151142_add_data_to_taskStatuses
 */
class m220929_151142_add_data_to_taskStatuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'taskStatuses',
            ['taskStatus'],
            [
                ['new'],
                ['cancelled'],
                ['in work'],
                ['done'],
                ['failed'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('taskStatuses');
    }
}
