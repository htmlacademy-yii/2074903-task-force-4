<?php declare(strict_types=1);

namespace omarinina\infrastructure\exception\file;

use Exception;

class FileExistException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Файл не существует',
            0,
            null);
    }
}
