<?php declare(strict_types=1);

namespace omarinina\domain\actions;

abstract class AbstractAction
{
    /** @var int */
    protected int $idClient;

    /** @var int */
    protected int $idExecutor;

    /**
     * @param int $idClient
     * @param int $idExecutor
     */
    public function __construct(int $idClient, int $idExecutor)
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
     * @param int $idUser
     * @return boolean
     */
    abstract public function isAvailableForUser(int $idUser): bool;
}
