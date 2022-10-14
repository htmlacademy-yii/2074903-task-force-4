<?php

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
            '/img/avatars/1.png',
            '/img/avatars/2.png',
            '/img/avatars/3.png',
            '/img/avatars/4.png',
            '/img/avatars/5.png',
        ]
    ),
    'birthDate' => $faker->date('Y-m-d','-18 years'),
    'phone' => $faker->phoneNumber(),
    'telegram' => $faker->lexify('@???????'),
    'bio' => $faker->text()
];
