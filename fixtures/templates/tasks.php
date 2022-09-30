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
    'categoryId' => $faker->numberBetween(1, 8),
    'cityId' => $faker->numberBetween(1,1087),
    'status' => $faker->numberBetween(1, 5),
    'executorId' => $faker->randomElement([$faker->randomElement($executors), null]),
    'clientId' => $faker->randomElement($clients)
];
