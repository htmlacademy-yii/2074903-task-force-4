<?php

declare(strict_types=1);

use omarinina\domain\models\task\Tasks;

$tasks = Tasks::find()->select('id')
    ->where(['status' => '4'] || ['status' => '5'])
    ->asArray()->all();

/**
 * @var $faker \Faker\Generator
 */
return [
    'taskId' => $faker->unique()->randomElement($tasks)['id'],
    'score' => $faker->numberBetween(1, 5),
    'comment' => $faker->text()
];
