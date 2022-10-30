<?php

use yii\db\Migration;

/**
 * Class m221023_075514_add_location_and_point_to_tasks
 */
class m221023_075514_add_location_and_point_to_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'location', $this->string(255));
        $this->addColumn('tasks', 'lat', $this->float(7));
        $this->addColumn('tasks', 'lng', $this->float(7));
        $this->dropForeignKey('TASK_CITY_ID', 'tasks');
        $this->dropColumn('tasks', 'cityId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('tasks', 'cityId', $this->integer());
        $this->addForeignKey(
            'TASK_CITY_ID',
            'tasks',
            'cityId',
            'cities',
            'id',
            'CASCADE'
        );
        $this->dropColumn('tasks', 'lng');
        $this->dropColumn('tasks', 'lat');
        $this->dropColumn('tasks', 'location');
    }
}
