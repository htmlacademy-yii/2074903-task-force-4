<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use yii\helpers\Url;
use omarinina\domain\models\task\Tasks;

class AcceptAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'accept';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Выполнено';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(Tasks $currentTask): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/accept-task',
                'taskId' => $currentTask->id
            ]) .
            '" class="button button--pink action-btn" data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
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
