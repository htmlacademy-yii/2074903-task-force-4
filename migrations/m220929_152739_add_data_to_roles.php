<?php

use yii\db\Migration;

/**
 * Class m220929_152739_add_data_to_roles
 */
class m220929_152739_add_data_to_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'roles',
            ['role'],
            [
                ['client'],
                ['executor']
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
