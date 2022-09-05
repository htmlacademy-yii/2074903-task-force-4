<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

class CancelAction extends AbstractAction
{
    public static function getInternalName(): string
    {
        return 'cancel';
    }

    public static function getName(): string
    {
        return 'Отменить';
    }

    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idClient->getId() === $idUser->getId();
    }
}
