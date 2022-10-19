<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\models\task\Tasks;
use omarinina\domain\models\user\Users;
use yii\helpers\Url;

class RespondAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'respond';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Откликнуться';
    }

    /**
     * @return string
     */
    public function getViewAvailableButton(Tasks $currentTask): string
    {
        return '<a href="' .
            Url::toRoute([
                'task-actions/respond-task',
                'taskId' => $currentTask->id
            ]) .
            '" class="button button--blue action-btn" data-action="' .
            static::getInternalName() . '">' .
            static::getName() . 'data-bs-toggle="modal" data-bs-target="#response-form"</a>';
    }

    /**
     * @param int $idUser
     * @return bool
     */
    public function isAvailableForUser(int $idUser): bool
    {
        if (!$this->task->getResponds()->where(['executorId' => $idUser])->one()) {
            return Users::findOne($idUser)->userRole->role === 'executor';
        }
        return false;
    }
}
