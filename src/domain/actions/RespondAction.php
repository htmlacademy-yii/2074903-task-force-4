<?php declare(strict_types=1);

namespace omarinina\domain\actions;

class RespondAction extends AbstractAction
{
    public static function getInternalName(): string
    {
        return 'respond';
    }

    public static function getName(): string
    {
        return 'Откликнуться';
    }

    public function isAvailableForUser(int $idUser, int $idClient, int $idExecutor): bool
    {
        return $idExecutor === $idUser;
    }
}
