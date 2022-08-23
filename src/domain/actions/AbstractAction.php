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
        $this->action = $this->getCurrentAction();
        return $this->action;
    }

    public function getNameAction(): string
    {
        $this->nameAction = $this->getCurrentNameAction();
        return $this->nameAction;
    }

    public function isValidUser(int $currentUser, string $currentAction): bool | null
    {
        if ($currentAction === $this->action) {
            return $currentUser === $this->defineAccess() ?  true : false;
        }
    }

    abstract protected function getCurrentAction(): string;
    abstract protected function getCurrentNameAction(): string;

    abstract protected function defineAccess(): int;

    //abstract protected function applyAction($action);
}
