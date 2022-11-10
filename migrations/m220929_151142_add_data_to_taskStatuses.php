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
            ['taskStatus', 'name'],
            [
                ['new', 'Новое'],
                ['cancelled', 'Отменено'],
                ['in work', 'В работе'],
                ['done', 'Выполнено'],
                ['failed', 'Провалено'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
