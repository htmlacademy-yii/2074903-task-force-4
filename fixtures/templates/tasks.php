<?php

use omarinina\domain\valueObjects\UniqueIdentification;

/**
 * @var $faker \Faker\Generator
 */
return [
    'uuid' => UniqueIdentification::createInst()->getId(),
    'name' => $faker->words(3, true),
    'description' => $faker->text(),
    'expiryDate' => $faker->dateTimeBetween('now', '+2 months'),
    'budget' => $faker->randomNumber(4,true),
    'categoryId' => $faker->randomDigitNot(9),
    'lat' => $faker->randomFloat(7,41,81),
    'lng' => $faker->randomFloat(7, 19,169),
    'status' => $faker->randomElements([1, 2, 3, 4, 5])
];
