<?php

use omarinina\domain\models\user\Users;
use omarinina\domain\models\Categories;

$users = Users::find();
$users->joinWith('roles', true)->where(['roles.role' => 'executor']);
$executors = $users->all();
if ($executors) {
    $executorsAr = $users->select('uuid')->asArray();
}
if (!$executors) {
    \PHPUnit\Framework\throwException();
}

$categories = Categories::find();
$categoriesId = $categories->select('id')->asArray();

/**
 * @var $faker \Faker\Generator
 */
return [
    'executorId' => $faker->unique()->randomElement($executorsAr),
    'categoryId' => $faker->randomElement($categoriesId)
];
