<?php

namespace omarinina\application\services\task\dto;

class NewTaskDto
{
    /** @var array */
    public array $attributes;

    /** @var int */
    public int $userId;

    /** @var string|null */
    public ?string $formExpiryDate;

    /** @var object|null */
    public ?object $geoObject;

    /**
     * @param array $attributes
     * @param int $userId
     * @param string|null $formExpiryDate
     * @param object|null $geoObject
     */
    public function __construct(array $attributes, int $userId, ?string $formExpiryDate, ?object $geoObject)
    {
        $this->attributes = $attributes;
        $this->userId = $userId;
        $this->formExpiryDate = $formExpiryDate;
        $this->geoObject = $geoObject;
    }
}
