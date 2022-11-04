<?php

declare(strict_types=1);

namespace omarinina\application\services\task\create;

use omarinina\domain\models\Cities;
use omarinina\domain\models\task\Tasks;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use omarinina\infrastructure\constants\TaskStatusConstants;

class ServiceTaskCreate
{
    /**
     * @param array $attributes
     * @param int $userId
     * @param string|null $formExpiryDate
     * @param object|null $GeoObject
     * @return Tasks|null
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public static function saveNewTask(
        array $attributes,
        int $userId,
        ?string $formExpiryDate,
        ?object $GeoObject
    ) : ?Tasks {
        $createdTask = new Tasks();
        $createdTask->attributes = $attributes;
        $createdTask->clientId = $userId;
        $createdTask->status = TaskStatusConstants::ID_NEW_STATUS;
        if ($GeoObject) {
            $city = explode(',', $GeoObject->description)[0];
            if (!Cities::findOne(['name' => $city])) {
                throw new NotFoundHttpException('This city is not founded', 404);
            }
            $createdTask->city = $city;
            $createdTask->address = $GeoObject->name;
            $coordinates = explode(' ', $GeoObject->Point->pos);
            $createdTask->lat = $coordinates[1];
            $createdTask->lng = $coordinates[0];
        }
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
