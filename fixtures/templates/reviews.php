<?php

use omarinina\domain\models\task\Tasks;

$tasks = Tasks::find()->select('id')
    ->where(['status' => '4'] || ['status' => '5'])
    ->asArray()->all();

/**
 * @var $faker \Faker\Generator
 */
return [
    'taskId' => $faker->unique()->randomElement($tasks)['id'],
    'score' => $faker->randomElement([1, 2, 3, 4, 5]),
    'comment' => $faker->text()
];
