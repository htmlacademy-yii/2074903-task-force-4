<?php

use omarinina\domain\models\user\Roles;

$executors = array_map(
    function ($users) { return $users->id; },
    Roles::findOne(['role' => 'executor'])->users);

/**
 * @var $faker \Faker\Generator
 */
return [
    'executorId' => $faker->randomElement($executors),
    'categoryId' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8])
];
