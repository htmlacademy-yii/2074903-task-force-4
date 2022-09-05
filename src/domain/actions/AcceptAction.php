<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

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
     * @param UserId $idUser
     * @return boolean
     */
    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idClient->getId() === $idUser->getId();
    }
}
