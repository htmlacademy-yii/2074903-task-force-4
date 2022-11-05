<?php

declare(strict_types=1);

namespace omarinina\application\services\respond\interfaces;

interface RespondCreateInterface
{
    public function saveNewRespond(int $userId, int $taskId, ?array $attributes = null);
}
