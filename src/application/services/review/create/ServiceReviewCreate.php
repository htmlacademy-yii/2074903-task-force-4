<?php

declare(strict_types=1);

namespace omarinina\application\services\review\create;

use omarinina\domain\models\task\Reviews;
use omarinina\domain\models\task\Tasks;
use omarinina\infrastructure\constants\ReviewConstants;
use omarinina\infrastructure\constants\TaskConstants;
use Yii;
use yii\caching\TagDependency;
use yii\web\ServerErrorHttpException;

class ServiceReviewCreate
{
    /**
     * @param Tasks $task
     * @param array $attributes
     * @return Reviews|null
     * @throws ServerErrorHttpException
     */
    public static function createNewReview(Tasks $task, array $attributes) : ?Reviews
    {
        $newReview = new Reviews();
        $newReview->attributes = $attributes;
        $newReview->taskId = $task->id;
        $newReview->executorId = $task->executorId;
        $newReview->clientId = $task->clientId;
        if (!$newReview->save(false)) {
            throw new ServerErrorHttpException(
                'Your data has not been recorded, please try again later',
                500
            );
        }
        TagDependency::invalidate(Yii::$app->cache, ReviewConstants::CACHE_TAG);
        TagDependency::invalidate(Yii::$app->cache, TaskConstants::CACHE_EXECUTOR_TAG);

        return $newReview;
    }
}
