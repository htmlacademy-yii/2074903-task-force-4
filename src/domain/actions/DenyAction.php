<?php declare(strict_types=1);

namespace omarinina\domain\actions;

class DenyAction extends AbstractAction
{
    protected function getCurrentAction(): string
    {
        return $this->action = 'deny';
    }

    protected function getCurrentNameAction(): string
    {
        return $this->nameAction = 'Отказаться';
    }

    protected function getCurrentAvailableUSer(): string
    {
        return 'executor';
    }
}
