<?php

namespace omarinina\application\services\task\addData;

use omarinina\domain\models\task\Responds;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\constants\TaskStatusConstants;
use yii\web\ServerErrorHttpException;

class ServiceTaskDataAdd
{
    /**
     * @param Responds $respond
     * @param int $userId
     * @return Tasks|null
     * @throws ServerErrorHttpException
     */
    public static function addExecutorIdToTask(Responds $respond, int $userId) : ?Tasks
    {
        $task = $respond->task;
        if ($userId === $task->clientId && $task->status === TaskStatusConstants::ID_NEW_STATUS) {
            if (!$task->addExecutorId($respond)) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }
            return $task;
        }
        return null;
    }
}
