<?php

namespace omarinina\domain\exception\task;

use Exception;

class IdUSerException extends Exception
{
    public function __construct()
    {
        parent::__construct('У вас нет доступа для внесения изменений');
    }
}
