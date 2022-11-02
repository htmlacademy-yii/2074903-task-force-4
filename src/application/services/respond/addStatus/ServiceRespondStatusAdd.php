<?php

namespace omarinina\application\services\respond\addStatus;

use omarinina\domain\models\task\Responds;
use omarinina\infrastructure\constants\TaskStatusConstants;
use yii\web\ServerErrorHttpException;
use Yii;

class ServiceRespondStatusAdd
{
    /**
     * @param Responds $respond
     * @param int $userId
     * @return Responds|null
     * @throws ServerErrorHttpException
     */
    public static function addAcceptStatus(Responds $respond, int $userId) : ?Responds
    {
        $task = $respond->task;
        if ($userId === $task->clientId && $task->status === TaskStatusConstants::ID_NEW_STATUS) {
            if (!$respond->addAcceptedStatus()) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }

            return $respond;
        }
        return null;
    }

    /**
     * @param Responds $respond
     * @param int $userId
     * @return void
     * @throws ServerErrorHttpException
     */
    public static function addRefuseStatus(Responds $respond, int $userId) : void
    {
        $task = $respond->task;
        if ($userId === $task->clientId && $task->status === TaskStatusConstants::ID_NEW_STATUS) {
            if (!$respond->addRefusedStatus()) {
                throw new ServerErrorHttpException(
                    'Your data has not been recorded, please try again later',
                    500
                );
            }
        }
    }

    /**
     * @param Responds[] $responds
     * @param Responds|null $acceptedRespond
     * @return void
     * @throws ServerErrorHttpException|\Throwable
     */
    public static function addRestRespondsRefuseStatus(array $responds, ?Responds $acceptedRespond = null) : void
    {
        if (isset($responds[0])) {
            Yii::$app->db->transaction(function ($responds) use ($acceptedRespond) {
                foreach ($responds as $respond) {
                    if (!$respond->status && $respond->id !== $acceptedRespond->id) {
                        /** @var Responds $respond */
                        $respond->addRefusedStatus();
                    }
                }
            });
        }
    }
}
