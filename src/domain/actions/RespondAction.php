<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

class RespondAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'respond';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Откликнуться';
    }

    /**
     * @param UserId $idUser
     * @return boolean
     */
    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idExecutor->getId() === $idUser->getId();
    }
}
