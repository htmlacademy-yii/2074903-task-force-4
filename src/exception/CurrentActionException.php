<?php

namespace omarinina\exception;

use Exception;

class CurrentActionException extends Exception
{
    public function __construct()
    {
        parent::__construct('Вам недоступно данное действие, выберите из предложенных', 0, null);
    }
}