<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\task\Tasks;
use yii\helpers\Url;

class CancelAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'cancel';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Отменить';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(Tasks $currentTask): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/cancel-task',
                'taskId' => $currentTask->id
            ]) .
            '" class="button button--pink action-btn" data-action="' .
            static::getInternalName() . '">' .
            static::getName() . 'data-bs-toggle="modal" data-bs-target="#cancellation-form"</a>';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->task->clientId === $idUser;
    }
}
