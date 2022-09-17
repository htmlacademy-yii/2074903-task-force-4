<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

class CancelAction extends AbstractAction
{
    /**
     * @return string
     */
    public static function getInternalName(): string
    {
        return 'cancel';
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Отменить';
    }

    /**
     * @param UserId $idUser
     * @return boolean
     */
    public function isAvailableForUser(UserId $idUser): bool
    {
        return $this->idClient->getId() === $idUser->getId();
    }
}
