<?php

namespace omarinina\domain\valueObjects;

class Phone
{
    /** @var string */
    private string $phone;

    /**
     * @param string $phone
     */
    public function __construct(string $phone)
    {
        $correctPhone = (int)substr($phone, 0, 1) === 7 ?
            '+' . $phone : '+7' . (int)substr($phone, 1, 10);
        $this->phone = $correctPhone;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}
