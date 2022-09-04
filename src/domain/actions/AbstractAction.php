<?php declare(strict_types=1);

namespace omarinina\domain\actions;

use omarinina\domain\valueObjects\UserId;

abstract class AbstractAction
{
    protected UserId $idClient;
    protected UserId $idExecutor;

    public function __construct(UserId $idClient, UserId $idExecutor)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
    }

    abstract public static function getInternalName(): string;
    abstract public static function getName(): string;
    abstract public function isAvailableForUser(UserId $idUser): bool;
}
