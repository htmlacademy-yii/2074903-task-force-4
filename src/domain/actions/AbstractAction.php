<?php declare(strict_types=1);

namespace omarinina\domain\actions;

abstract class AbstractAction
{
    abstract public static function getInternalName(): string;
    abstract public static function getName(): string;
    abstract public function isAvailableForUser(int $idUser, int $idClient, int $idExecutor): bool;
}
