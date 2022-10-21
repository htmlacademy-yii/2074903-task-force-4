<?php

namespace omarinina\application\services\task\change_status;

use omarinina\domain\actions\AcceptAction;
use omarinina\domain\actions\CancelAction;
use omarinina\domain\actions\DenyAction;
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
        if ($userId === $task->clientId) {
            $task->status = $task->changeStatusByAction(
                CancelAction::getInternalName(),
                $userId
            );
            if (!$task->save(false)) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }
            return true;
        }
        return false;
    }

    public static function changeStatusToFailed(Tasks $task, int $userId)
    {
        if ($userId === $task->executorId) {
            $task->status = $task->changeStatusByAction(
                DenyAction::getInternalName(),
                $userId
            );
            if (!$task->save(false)) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }
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
        if ($userId === $task->clientId) {
            $task->status = $task->changeStatusByAction(
                AcceptAction::getInternalName(),
                $userId
            );
            if (!$task->save(false)) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }
            return true;
        }
        return false;
    }
}
