<?php

namespace omarinina\application\services\respond\dto;

class NewRespondDto
{
    public int $userId;
    public int $taskId;
    public ?array $formAttributes;

    public function __construct(
        int $userId,
        int $taskId,
        ?array $attributes
    ) {
        $this->userId = $userId;
        $this->taskId = $taskId;
        $this->formAttributes = $attributes;
    }
}
