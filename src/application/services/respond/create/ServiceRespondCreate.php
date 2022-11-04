<?php

namespace omarinina\application\services\respond\create;

use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\Users;
use yii\web\ServerErrorHttpException;

class ServiceRespondCreate
{
    /**
     * @param Users $user
     * @param Tasks $task
     * @param array|null $attributes
     * @return void
     * @throws ServerErrorHttpException
     */
    public static function saveNewRespond(Users $user, Tasks $task, ?array $attributes = null): void
    {
        $newRespond = new Responds();
        if ($attributes) {
            $newRespond->attributes = $attributes;
        }
        $newRespond->taskId = $task->id;
        $newRespond->executorId = $user->id;
        if (!$newRespond->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }
}
