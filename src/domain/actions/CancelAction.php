<?php declare(strict_types=1);

namespace omarinina\domain\actions;

class CancelAction extends AbstractAction
{
    protected function getCurrentAction(): string
    {
        return $this->action = 'cancel';
    }

    protected function getCurrentNameAction(): string
    {
        return $this->nameAction = 'Отменить';
    }

    protected function defineAccess(): int
    {
        $accessUser = $this->idClient;
        return $accessUser;
    }
}
