<?php

declare(strict_types=1);

use omarinina\domain\models\user\Roles;
use omarinina\domain\models\Cities;

unset(Roles::findOne(['role' => 'executor'])->users);
unset(Roles::findOne(['role' => 'client'])->users);
$executors = array_map(
    function ($users) {
        return $users->id;
    },
    Roles::findOne(['role' => 'executor'])->users
);
$clients = array_map(
    function ($users) {
        return $users->id;
    },
    Roles::findOne(['role' => 'client'])->users
);
$cities = Cities::find()->select('name')->asArray()->all();

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
    'budget' => $faker->randomNumber(4, true),
    'categoryId' => $faker->numberBetween(1, 8),
    'city' => $faker->randomElement([$faker->randomElement($cities)['name'], null]),
    'status' => $faker->numberBetween(1, 5),
    'executorId' => $faker->randomElement([$faker->randomElement($executors), null]),
    'clientId' => $faker->randomElement($clients)
];
