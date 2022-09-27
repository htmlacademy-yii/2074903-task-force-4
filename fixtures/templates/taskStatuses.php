<?php

/**
 * @var $faker \Faker\Generator
 */
return [
    'taskStatus' => $faker->randomElements([
        'Новое',
        'Отменено',
        'В работе',
        'Выполнено',
        'Провалено'])
];
