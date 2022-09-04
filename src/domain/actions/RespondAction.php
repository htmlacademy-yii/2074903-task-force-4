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

    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idExecutor === $idUser;
    }
}
