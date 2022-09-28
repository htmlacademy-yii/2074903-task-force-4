<?php

use omarinina\domain\valueObjects\UniqueIdentification;

/**
 * @var $faker \Faker\Generator
 */
return [
    'uuid' => UniqueIdentification::createInst()->getId(),
    'email' => $faker->email(),
    'name' => $faker->userName(),
    'password' => $faker->password(),
    'role' => $faker->boolean(),
    'city' => $faker->numberBetween(1,1087)
];
