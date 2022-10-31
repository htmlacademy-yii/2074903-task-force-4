<?php

namespace omarinina\application\services\task\filter;

use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\constants\TaskStatusConstants;
use Yii;
use yii\db\Query;

class ServiceTaskFilter
{
    /**
     * @param int $clientId
     * @param int|null $status
     * @return Tasks[]
     * @throws \Throwable
     */
    public static function filterClientTasks(int $clientId, ?int $status = null) : array
    {
        /** @var Query $allClientTasks */
        $allClientTasks = Yii::$app->db->cache(function () use ($clientId) {
            return Tasks::find()->where(['clientId' => $clientId]);
        });
        if (!$status) {
            return $allClientTasks->andWhere(['status' => TaskStatusConstants::ID_NEW_STATUS])->all();
        }
        return $allClientTasks->andWhere(['status' => $status])->all();
    }

    /**
     * @param int $executorId
     * @param int|null $status
     * @return Tasks[]
     * @throws \Throwable
     */
    public static function filterExecutorTasks(int $executorId, ?int $status = null) : array
    {
        /** @var Query $allExecutorTasks */
        $allExecutorTasks = Yii::$app->db->cache(function () use ($executorId) {
            return Tasks::find()->where(['executorId' => $executorId]);
        });
        if (!$status) {
            return $allExecutorTasks->andWhere(['status' => TaskStatusConstants::ID_IN_WORK_STATUS])->all();
        } elseif ($status === TaskStatusConstants::ID_OVERDUE_STATUS) {
            return $allExecutorTasks
                ->andWhere(['status' => TaskStatusConstants::ID_IN_WORK_STATUS])
                ->andWhere('tasks.expiryDate < NOW()')
                ->all();
        }
        return $allExecutorTasks->andWhere(['status' => $status])->all();
    }
}
