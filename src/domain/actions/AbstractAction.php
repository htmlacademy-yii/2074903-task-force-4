<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UniqueIdentification;

abstract class AbstractAction
{
    /** @var UniqueIdentification */
    protected UniqueIdentification $idClient;

    /** @var UniqueIdentification */
    protected UniqueIdentification $idExecutor;

    /**
     * @param UniqueIdentification $idClient
     * @param UniqueIdentification $idExecutor
     */
    public function __construct(UniqueIdentification $idClient, UniqueIdentification $idExecutor)
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
     * @param UniqueIdentification $idUser
     * @return boolean
     */
    abstract public function isAvailableForUser(UniqueIdentification $idUser): bool;
}
