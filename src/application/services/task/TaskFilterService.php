<?php

declare(strict_types=1);

namespace omarinina\application\services\task;

use omarinina\application\services\task\interfaces\TaskFilterInterface;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\constants\TaskStatusConstants;

class TaskFilterService implements TaskFilterInterface
{
    /**
     * @param int $clientId
     * @param int|null $status
     * @return Tasks[]
     * @throws \Throwable
     */
    public function filterClientTasksByStatus(int $clientId, ?int $status = null) : array
    {
        return Tasks::find()
            ->where(['clientId' => $clientId])
            ->andWhere(['status' => $status ?? TaskStatusConstants::ID_NEW_STATUS])
            ->all();
    }

    /**
     * @param int $executorId
     * @param int|null $status
     * @return Tasks[]
     * @throws \Throwable
     */
    public function filterExecutorTasksByStatus(int $executorId, ?int $status = null) : array
    {
        $allExecutorTasks = Tasks::find()->where(['executorId' => $executorId]);
        if ($status === TaskStatusConstants::ID_OVERDUE_STATUS) {
            $allExecutorTasks = $allExecutorTasks
                ->andWhere(['status' => TaskStatusConstants::ID_IN_WORK_STATUS])
                ->andWhere('tasks.expiryDate < NOW()');
        } else {
            $allExecutorTasks = $allExecutorTasks
                ->andWhere(['status' => $status ?? TaskStatusConstants::ID_IN_WORK_STATUS]);
        }
        return $allExecutorTasks->all();
    }
}
