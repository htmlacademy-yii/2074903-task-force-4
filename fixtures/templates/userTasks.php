<?php

use omarinina\domain\models\user\Users;
use omarinina\domain\models\task\Tasks;

$users = Users::find();
$userRows = $users->all();
if ($userRows) {
    $usersUuid = $users->select('uuid')->asArray();
}
if (!$userRows) {
    \PHPUnit\Framework\throwException();
}

$tasks = Tasks::find();
$taskRows = $tasks->all();
if ($taskRows) {
    $tasksUuid = $tasks->select('uuid')->asArray();
}
if (!$taskRows) {
    \PHPUnit\Framework\throwException();
}

/**
 * @var $faker \Faker\Generator
 */
return [
    'userId' => $faker->unique()->randomElement($usersUuid),
    'taskId' => $faker->randomElement($tasksUuid)
];
