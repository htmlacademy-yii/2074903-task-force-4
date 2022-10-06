<?php

namespace omarinina\infrastructure\statistic;

use omarinina\domain\models\task\TaskStatuses;
use omarinina\domain\models\user\Users;
use omarinina\domain\models\user\Roles;
use Yii;
use yii\db\ActiveRecord;

class ExecutorStatistic
{
    /** @var int */
    private int $id;

    /** @var Users */
    private Users $executor;

    const STATUS_BUSY = 'busy';
    const STATUS_FREE = 'free';

    const STATUS_BUSY_NAME = 'Занят';
    const STATUS_FREE_NAME = 'Открыт для новых заказов';

    const MAX_RATING = 5;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->executor = Users::findOne($this->id);
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
        $currentTask = $this->executor->getExecutorTasks()
            ->where('tasks.status = 3')->all();
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
        $commonScore = array_sum(array_map(function ($executorReviews) {
            return $executorReviews->score; }, $this->executor->executorReviews));
        return $this->getCountReviews() ?
            round($commonScore / ($this->getCountReviews() + $this->getCountFailedTasks()), 2) :
            0;
    }

    /**
     * @return int
     */
    public function getCountFailedTasks(): int
    {
        return $this->executor->getExecutorTasks()
            ->where('tasks.status = 5')->count();
    }

    /**
     * @return int
     */
    public function getCountDoneTasks(): int
    {
        return $this->executor->getExecutorTasks()
            ->where('tasks.status = 4')->count();
    }

    //Место в рейтинге расчитывается так: для каждого исполнителя считается его общий балл,
    // равный среднему арифмитеческому по всем оценкам за выполненные заказы
    private function getExecutorRatingPlace(Users $user): int
    {
        $reviewTasks = array_map(
            function ($executorReviews) { return $executorReviews->taskId; },
            $user->executorReviews);
        $doneTasks = array_map(
            function ($tasks) { return $tasks->id; },
            TaskStatuses::findOne(['taskStatus' => 'done'])->tasks);
        foreach ($reviewTasks as $reviewTask) {
            if (!in_array($reviewTask, $doneTasks)) {
                unset($reviewTasks[array_search($reviewTask, $reviewTasks)]);
            }
        }
        $commonScore = array_sum($reviewTasks);
        $countReviewDoneTasks = count($reviewTasks);
        return $countReviewDoneTasks ?
            round($commonScore / $countReviewDoneTasks, 2) :
            0;
    }

    public function getExecutorPlace(): int
    {
        $allRating = array_map(
            function ($users) { return $this->getExecutorRatingPlace($users); },
            Roles::findOne(['role' => 'executor'])->users);
        $currentExecutorRating = $this->getExecutorRatingPlace($this->executor);
        rsort($allRating);
        return array_search($currentExecutorRating, $allRating) + 1;
    }
}
