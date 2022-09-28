<?php

/**
 * @var $faker \Faker\Generator
 */
return [
    'executorStatus' => $faker->unique()->randomElements(['Открыт для новых заказов', 'Занят'])
];
