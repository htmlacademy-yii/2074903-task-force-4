<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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

    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idClient === $idUser;
    }
}
