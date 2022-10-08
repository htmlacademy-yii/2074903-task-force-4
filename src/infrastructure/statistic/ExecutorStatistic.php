<?php

namespace omarinina\infrastructure\statistic;

use omarinina\domain\models\user\Users;
use omarinina\domain\models\user\Roles;
use Yii;

class ExecutorStatistic
{
    /** @var Users */
    private Users $executor;

    public const STATUS_BUSY = 'busy';
    public const STATUS_FREE = 'free';

    public const STATUS_BUSY_NAME = 'Занят';
    public const STATUS_FREE_NAME = 'Открыт для новых заказов';

    public const MAX_RATING = 5;

    public function __construct(Users $model)
    {
        $this->executor = $model;
    }

    /**
     * @return string[]
     */
    private function getMapExecutorStatus(): array
    {
        return [
            self::STATUS_BUSY => self::STATUS_BUSY_NAME,
            self::STATUS_FREE => self::STATUS_FREE_NAME
        ];
    }

    /**
     * @return string
     */
    public function getExecutorCurrentStatus(): string
    {
        $currentTask = $this->executor->executorInWorkTasks;
        return $currentTask ?
            $this->getMapExecutorStatus()[self::STATUS_BUSY] :
            $this->getMapExecutorStatus()[self::STATUS_FREE];
    }

    /**
     * @return int
     */
    public function getCountReviews(): int
    {
        return $this->executor->getExecutorReviews()->count();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getExecutorCreateAt(): string
    {
        return Yii::$app->formatter->asDate($this->executor->createAt, 'dd MMMM, HH:mm');
    }

    /**
     * @return float
     */
    public function getExecutorRating(): float
    {
        $commonScore = array_sum(
            array_map(
                function ($executorReviews) {
                    return $executorReviews->score;
                },
                $this->executor->executorReviews
            )
        );
        return $this->getCountReviews() ?
            round($commonScore / ($this->getCountReviews() + $this->getCountFailedTasks()), 2) :
            0;
    }

    /**
     * @return int
     */
    public function getCountFailedTasks(): int
    {
        return $this->executor->getExecutorFailedTasks()->count();
    }

    /**
     * @return int
     */
    public function getCountDoneTasks(): int
    {
        return $this->executor->getExecutorDoneTasks()->count();
    }

    /**
     * @param Users $user
     * @return float
     */
    private function getExecutorRatingPlace(Users $user): float
    {
        $reviewTasks = array_map(
            function ($executorReviews) {
                return $executorReviews->taskId;
            },
            $user->executorReviews
        );
        $doneTasks = array_map(
            function ($executorDoneTasks) {
                return $executorDoneTasks->id;
            },
            $user->executorDoneTasks
        );
        foreach ($reviewTasks as $reviewTask) {
            if (!in_array($reviewTask, $doneTasks)) {
                $taskKey = array_search($reviewTask, $reviewTasks);
                unset($reviewTasks[$taskKey]);
            }
        }
        $commonScore = array_sum($reviewTasks);
        $countReviewDoneTasks = count($reviewTasks);
        return $countReviewDoneTasks ?
            round($commonScore / $countReviewDoneTasks, 2) :
            0;
    }

    /**
     * @return int
     */
    public function getExecutorPlace(): int
    {
        $allRating = array_map(
            function ($users) {
                return $this->getExecutorRatingPlace($users);
            },
            Roles::findOne(['role' => 'executor'])->users
        );
        $currentExecutorRating = $this->getExecutorRatingPlace($this->executor);
        rsort($allRating);
        return array_search($currentExecutorRating, $allRating) + 1;
    }
}
