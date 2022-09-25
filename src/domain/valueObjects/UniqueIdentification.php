<?php declare(strict_types=1);

namespace omarinina\domain\valueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UniqueIdentification
{
    /** @var string */
    private string $uuid;

    /**
     * @param string|null $uuid
     */
    public function __construct(?string $uuid)
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4()->toString();
        }

        Uuid::isValid($uuid);

        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     * @return UniqueIdentification
     */
    static function createInst(?string $uuid = null)
    {
        return new self($uuid);
    }
}
