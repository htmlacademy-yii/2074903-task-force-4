<?php

declare(strict_types=1);

namespace omarinina\application\services\respond;

use omarinina\application\services\respond\interfaces\RespondStatusAddInterface;
use omarinina\domain\models\task\Responds;
use omarinina\infrastructure\constants\TaskStatusConstants;
use yii\web\ServerErrorHttpException;
use Yii;

class RespondStatusAddService implements RespondStatusAddInterface
{
    /**
     * @param Responds $respond
     * @param int $userId
     * @return Responds|null
     * @throws ServerErrorHttpException
     */
    public function addAcceptStatus(Responds $respond, int $userId) : ?Responds
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
    public function addRefuseStatus(Responds $respond, int $userId) : void
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
    public function addRestRespondsRefuseStatus(array $responds, ?Responds $acceptedRespond = null) : void
    {
        if (isset($responds[0])) {
            Yii::$app->db->transaction(function () use ($responds, $acceptedRespond) {
                foreach ($responds as $respond) {
                    if (!$respond->status && $respond->id !== $acceptedRespond->id) {
                        $respond->addRefusedStatus();
                    }
                }
            });
        }
    }
}
