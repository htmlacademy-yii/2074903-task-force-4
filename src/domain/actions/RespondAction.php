<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

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

    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idExecutor->getId() === $idUser->getId();
    }
}
