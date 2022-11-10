<?php

declare(strict_types=1);

namespace omarinina\domain\actions;

class DenyAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'failed';
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
        return '<a class="button button--orange action-btn"
            data-action="refusal">' .
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
