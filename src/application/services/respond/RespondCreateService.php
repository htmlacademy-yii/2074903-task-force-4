<?php

declare(strict_types=1);

namespace omarinina\application\services\respond;

use omarinina\application\services\respond\interfaces\RespondCreateInterface;
use omarinina\domain\models\task\Responds;
use yii\web\ServerErrorHttpException;

class RespondCreateService implements RespondCreateInterface
{
    /**
     * @param int $userId
     * @param int $taskId
     * @param array|null $attributes
     * @return void
     * @throws ServerErrorHttpException
     */
    public function saveNewRespond(int $userId, int $taskId, ?array $attributes = null): void
    {
        $newRespond = new Responds();
        if ($attributes) {
            $newRespond->attributes = $attributes;
        }
        $newRespond->taskId = $taskId;
        $newRespond->executorId = $userId;
        if (!$newRespond->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
    }
}
