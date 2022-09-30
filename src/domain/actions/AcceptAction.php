<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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
     * @param int $idUser
     * @return boolean
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idClient === $idUser;
    }
}
