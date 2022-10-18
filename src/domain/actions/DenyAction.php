<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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
     * @return string
     */
    public function getViewAvailableButton(): string
    {
        return '<a href="' .
            Url::toRoute(['task-actions/deny-task']) .
            '" class="button button--orange action-btn" data-action="' .
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
