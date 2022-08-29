<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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

    public function isAvailableForUser(int $idUser, int $idClient, int $idExecutor): bool
    {
        return $idClient === $idUser;
    }
}
