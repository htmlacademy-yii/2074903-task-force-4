<?php declare(strict_types=1);

namespace omarinina\domain\actions;

abstract class AbstractAction
{
    protected $idClient;
    protected $idExecutor;

    public function __construct(int $idClient, int $idExecutor)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
    }

    abstract public static function getInternalName(): string;
    abstract public static function getName(): string;
    abstract public function isAvailableForUser(int $idUser): bool;
}
