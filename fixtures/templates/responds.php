<?php

use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\Roles;

$executors = array_map(
    function ($users) { return $users->id; },
    Roles::findOne(['role' => 'executor'])->users);

$tasks = Tasks::find()->select('id')->asArray()->all();

/**
 * @var $faker \Faker\Generator
 */
return [
    'taskId' => $faker->randomElement($tasks)['id'],
    'executorId' => $faker->randomElement($executors),
    'price' => $faker->randomNumber(4,true),
    'comment' => $faker->text()
];
