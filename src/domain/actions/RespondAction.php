<?php declare(strict_types=1);

namespace omarinina\domain\actions;

class RespondAction extends AbstractAction
{
    protected function getCurrentAction(): string
    {
        return $this->action = 'respond';
    }

    protected function getCurrentNameAction(): string
    {
        return $this->nameAction = 'Откликнуться';
    }

    protected function getCurrentAvailableUSer(): string
    {
        return 'executor';
    }
}
