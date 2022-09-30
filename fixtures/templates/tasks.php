<?php

use omarinina\domain\models\user\Roles;

$executors = array_map(
    function ($users) { return $users->id; },
    Roles::findOne(['role' => 'executor'])->users);
$clients = array_map(
    function ($users) { return $users->id; },
    Roles::findOne(['role' => 'client'])->users);

/**
 * @var $faker \Faker\Generator
 */
return [
    'name' => $faker->words(3, true),
    'description' => $faker->text(),
    'expiryDate' => date(
        'Y-m-d H:i:s',
        Yii::$app->formatter->asTimestamp(
            $faker->dateTimeBetween('now', '+2 months')
        )
    ),
    'budget' => $faker->randomNumber(4,true),
    'categoryId' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8]),
    'lat' => $faker->randomFloat(7,41,81),
    'lng' => $faker->randomFloat(7, 19,169),
    'status' => $faker->randomElement([1, 2, 3, 4, 5]),
    'executorId' => $faker->randomElement([$faker->randomElement($executors), null]),
    'clientId' => $faker->randomElement($clients)
];
