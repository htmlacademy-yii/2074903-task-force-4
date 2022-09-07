<?php declare(strict_types=1);

namespace omarinina\infrastructure\exception;

use Exception;

class HeaderColumnsException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Количество столбцов в обработываемом файле не соответствует ожидаемым',
            0,
            null);
    }
}
