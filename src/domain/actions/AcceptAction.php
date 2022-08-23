<?php declare(strict_types=1);

namespace omarinina\domain\actions;

class AcceptAction extends AbstractAction
{
    protected function getCurrentAction(): string
    {
        return $this->action = 'accept';
    }

    protected function getCurrentNameAction(): string
    {
        return $this->nameAction = 'Выполнено';
    }

    protected function getCurrentAvailableUSer(): string
    {
        return 'client';
    }
}
