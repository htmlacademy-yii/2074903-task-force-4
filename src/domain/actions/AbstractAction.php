<?php declare(strict_types=1);

namespace omarinina\domain\actions;

abstract class AbstractAction
{
    private $action;
    private $nameAction;
    private $idClient;
    private $idExecutor;
    private $accessUser;

    public function __construct(int $idClient, int $idExecutor)
    {
        $this->idClient = $idClient;
        $this->idExecutor = $idExecutor;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getNameAction(): string
    {
        return $this->nameAction;
    }

    public function isValidUser($currentUser): bool
    {
        return $currentUser === $this->defineAccess() ?  true : false;
    }

    private function defineAccess(): int
    {
        return $this->accessUser;
    }

    abstract protected function applyAction($action);
}
