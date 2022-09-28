<?php

use omarinina\domain\models\user\Users;
use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\ExecutorStatuses;
use omarinina\domain\models\UserTasks;

$users = Users::find();
$users->joinWith('roles', true)->where(['roles.role' => 'executor']);
$executors = $users->all();
if ($executors) {
    $executorsAr = $users->select('uuid')->asArray();
}
if (!$executors) {
    \PHPUnit\Framework\throwException();
}

//найти все ид задач в статусе "в работе" через класс таск + таскСтатус
//найти в ид исполнителей к этим таск ид в классе юзертаск
//функция форыч всех ид исполнителей, если есть в массиве предыдущей выборки -
// записать ид статуса "занят", если нет - ид статуса "свободен"
$tasks = Tasks::find();
$tasks->joinWith('taskStatuses', true)
    ->where(['taskStatuses.taskStatus' => 'В работе']);
$activeTasks = $tasks->all();
if ($activeTasks) {
    $activeTaskIds = $tasks->select('uuid')->asArray();
    $activeExecutors = [];
    foreach ($activeTaskIds as $taskId) {
        $relations = UserTasks::find();
        $activeUsers = $relations->select('uuid')->where(['taskId' => $taskId])->asArray();
        foreach ($activeUsers as $user) {
            if (in_array($user, $executorsAr)) {
                $activeExecutors = [$user];
            }
        }
    }
    function getExecutorStatus($executor, $activeExecutors): string
    {
        return in_array($executor, $activeExecutors) ?
            ExecutorStatuses::findOne(['executorStatus' => 'Занят'])->id :
            ExecutorStatuses::findOne(['executorStatus' => 'Открыт для новых заказов'])->id;
    }
}
if (!$activeTasks) {
    \PHPUnit\Framework\throwException();
}

/**
 * @var $faker \Faker\Generator
 */
return [
    'uuid' => $faker->randomElement($executorsAr),
    'avatarSrc' => $faker->randomElement(
        [
            '@app/web/img/avatars/1.png',
            '@app/web/img/avatars/2.png',
            '@app/web/img/avatars/3.png',
            '@app/web/img/avatars/4.png',
            '@app/web/img/avatars/5.png',
        ]
    ),
    'birthDate' => $faker->unixTime(new DateTime('-18 years')),
    'phone' => $faker->phoneNumber(),
    'telegram' => $faker->lexify('@???????'),
    'bio' => $faker->text(),
    'status' => getExecutorStatus('uuid', $activeExecutors),
];
