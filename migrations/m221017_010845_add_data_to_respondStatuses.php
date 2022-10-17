<?php

use yii\db\Migration;

/**
 * Class m221017_010845_add_data_to_respondStatuses
 */
class m221017_010845_add_data_to_respondStatuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'respondStatuses',
            ['status'],
            [
                ['accepted'],
                ['refused']
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('respondStatuses');
    }
}
