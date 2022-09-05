<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

class AcceptAction extends AbstractAction
{
    public static function getInternalName(): string
    {
        return 'accept';
    }

    public static function getName(): string
    {
        return 'Выполнено';
    }

    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idClient->getId() === $idUser->getId();
    }
}
