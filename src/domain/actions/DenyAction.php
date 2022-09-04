<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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

    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idExecutor === $idUser;
    }
}
