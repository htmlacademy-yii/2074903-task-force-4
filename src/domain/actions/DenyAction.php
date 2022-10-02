<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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
     * @param int $idUser
     * @return boolean
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idExecutor === $idUser;
    }
}
