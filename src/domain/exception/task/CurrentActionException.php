<?php

declare(strict_types=1);

namespace omarinina\domain\exception\task;

use Exception;

class CurrentActionException extends Exception
{
    public function __construct()
    {
        parent::__construct('Вам недоступно данное действие, выберите из предложенных');
    }
}
