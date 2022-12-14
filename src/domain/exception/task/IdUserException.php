<?php

declare(strict_types=1);

namespace omarinina\domain\exception\task;

use Exception;

class IdUserException extends Exception
{
    public function __construct()
    {
        parent::__construct('У вас нет доступа для внесения изменений');
    }
}
