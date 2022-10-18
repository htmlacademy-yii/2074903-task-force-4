<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute(['task-actions/respond-task']) .
            '" class="button button--blue action-btn" data-action="' .
            static::getInternalName() . '">' .
            static::getName() . '</a>';
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
