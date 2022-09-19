<?php

namespace omarinina\domain\exception\task;

use Exception;

class AvailableActionsException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Вы не можете выполнить никакие действия с задачей на этом этапе');
    }
}
