<?php declare(strict_types=1);

namespace omarinina\infrastructure\exception;

use Exception;

class FileOpenException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Не удалось открыть файл для прочтения',
            0,
            null);
    }
}
