<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\task\Tasks;
use yii\helpers\Url;

class DenyAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'deny';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Отказаться';
    }

    /**
     * @param Tasks $currentTask
     * @return string
     */
    public function getViewAvailableButton(Tasks $currentTask): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/deny-task',
                'taskId' => $currentTask->id
            ]) .
            '" class="button button--orange action-btn" data-action="' .
            static::getInternalName() . '">' .
            static::getName() . 'data-bs-toggle="modal" data-bs-target="#denial-form"</a>';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->task->executorId === $idUser;
    }
}
