<?php declare(strict_types=1);

namespace omarinina\domain\actions;

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
     * @param int $idUser
     * @return boolean
     */
    public function isAvailableForUser(int $idUser): bool
    {
        return $this->idExecutor === $idUser;
    }
}
