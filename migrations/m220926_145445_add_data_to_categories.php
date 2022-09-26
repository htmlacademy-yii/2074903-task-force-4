<?php

use omarinina\domain\models\Categories;
use yii\db\Migration;

/**
 * Class m220926_145445_add_data_to_categories
 */
class m220926_145445_add_data_to_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'categories',
            ['name', 'icon'],
            [
                ['Курьерские услуги','courier'],
                ['Уборка','clean'],
                ['Переезды','cargo'],
                ['Компьютерная помощь','neo'],
                ['Ремонт квартирный','flat'],
                ['Ремонт техники','repair'],
                ['Красота','beauty'],
                ['Фото','photo'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Categories::deleteAll();
    }
}
