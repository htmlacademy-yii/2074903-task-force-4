<?php

declare(strict_types=1);

namespace omarinina\domain\actions;

class AcceptAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'done';
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
    public function getViewAvailableButton(): string
    {
        return '<a class="button button--pink action-btn"
            data-action="completion">' .
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
