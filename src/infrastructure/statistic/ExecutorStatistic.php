<?php

namespace omarinina\infrastructure\statistic;

use omarinina\domain\models\user\Users;
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
        $commonScore = 0;
        array_map(function ($executorReviews, $commonScore) {
            $currentScore = $executorReviews->score;
            return $commonScore =+ $currentScore; }, $this->executor->executorReviews);
        $failedTasks = $this->executor->getExecutorTasks()
            ->where('tasks.status = 5')->count();
        return $this->getCountReviews() ?
            round($commonScore / ($this->getCountReviews() + $failedTasks), 2) :
            0;
    }
}
