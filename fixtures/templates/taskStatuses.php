<?php

/**
 * @var $faker \Faker\Generator
 */
return [
    'taskStatus' => $faker->unique()->randomElements([
        'Новое',
        'Отменено',
        'В работе',
        'Выполнено',
        'Провалено'])
];
