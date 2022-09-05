<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

abstract class AbstractAction
{
    /** @var UserId */
    protected UserId $idClient;

    /** @var UserId */
    protected UserId $idExecutor;

    /**
     * @param UserId $idClient
     * @param UserId $idExecutor
     */
    public function __construct(UserId $idClient, UserId $idExecutor)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
    }

    /**
     * @return string
     */
    abstract public static function getInternalName(): string;

    /**
     * @return string
     */
    abstract public static function getName(): string;

    /**
     * @param UserId $idUser
     * @return boolean
     */
    abstract public function isAvailableForUser(UserId $idUser): bool;
}
