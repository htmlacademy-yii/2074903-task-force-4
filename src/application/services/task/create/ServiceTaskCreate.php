<?php

namespace omarinina\application\services\task\create;

use omarinina\domain\models\task\Tasks;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;
use omarinina\infrastructure\constants\TaskStatusConstants;

class ServiceTaskCreate
{
    /**
     * @param array $attributes
     * @param int $userId
     * @param string|null $formExpiryDate
     * @return Tasks|null
     * @throws ServerErrorHttpException
     * @throws InvalidConfigException
     */
    public static function saveNewTask(array $attributes, int $userId, ?string $formExpiryDate) : ?Tasks
    {
        $createdTask = new Tasks();
        $createdTask->attributes = Yii::$app->request->post('CreateTaskForm');
        $createdTask->clientId = Yii::$app->user->identity->id;
        $createdTask->status = TaskStatusConstants::ID_NEW_STATUS;
        if ($formExpiryDate !== null) {
            $createdTask->expiryDate = Yii::$app->formatter->asDate(
                $formExpiryDate,
                'yyyy-MM-dd HH:mm:ss'
            );
        }

        if (!$createdTask->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }

        return $createdTask;
    }
}
