<?php

namespace omarinina\application\services\task\change_status;

use omarinina\domain\exception\task\AvailableActionsException;
use omarinina\domain\exception\task\CurrentActionException;
use omarinina\domain\exception\task\IdUserException;
use omarinina\domain\models\task\Tasks;
use yii\web\ServerErrorHttpException;

class ServiceTaskStatusChange
{
    /**
     * @param Tasks $task
     * @param int $userId
     * @return bool
     * @throws ServerErrorHttpException
     * @throws AvailableActionsException
     * @throws CurrentActionException
     * @throws IdUserException
     */
    public static function changeStatusToCancelled(Tasks $task, int $userId): bool
    {
        if (!$task->addCancelledStatus($userId)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
        return true;
    }

    /**
     * @param Tasks $task
     * @param int $userId
     * @return void
     * @throws AvailableActionsException
     * @throws CurrentActionException
     * @throws IdUserException
     * @throws ServerErrorHttpException
     */
    public static function changeStatusToFailed(Tasks $task, int $userId) : void
    {
        if (!$task->addFailedStatus($userId)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }

    /**
     * @param Tasks $task
     * @param int $userId
     * @return bool
     * @throws AvailableActionsException
     * @throws CurrentActionException
     * @throws IdUserException
     * @throws ServerErrorHttpException
     */
    public static function changeStatusToDone(Tasks $task, int $userId): bool
    {
        if (!$task->addDoneStatus()) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
        return true;
    }

    /**
     * @param Tasks $task
     * @return void
     * @throws ServerErrorHttpException
     */
    public static function changeStatusToInWork(Tasks $task) : void
    {
        if (!$task->addInWorkStatus()) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }
}
