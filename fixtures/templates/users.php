<?php

use omarinina\domain\valueObjects\UniqueIdentification;

/**
 * @var $faker \Faker\Generator
 */
return [
    'email' => $faker->unique()->email(),
    'name' => $faker->userName(),
    'password' => $faker->password(),
    'role' => $faker->randomElement([1, 2]),
    'city' => $faker->numberBetween(1,1087),
    'avatarSrc' => $faker->randomElement(
        [
            '@app/web/img/avatars/1.png',
            '@app/web/img/avatars/2.png',
            '@app/web/img/avatars/3.png',
            '@app/web/img/avatars/4.png',
            '@app/web/img/avatars/5.png',
        ]
    ),
    'birthDate' => $faker->date('Y-m-d','-18 years'),
    'phone' => $faker->phoneNumber(),
    'telegram' => $faker->lexify('@???????'),
    'bio' => $faker->text()
];
