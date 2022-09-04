<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

class DenyAction extends AbstractAction
{
    public static function getInternalName(): string
    {
        return 'deny';
    }

    public static function getName(): string
    {
        return 'Отказаться';
    }

    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idExecutor === $idUser;
    }
}
