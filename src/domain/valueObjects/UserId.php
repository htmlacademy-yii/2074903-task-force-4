<?php declare(strict_types=1);

namespace omarinina\domain\valueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UserId
{
    /** @var string */
    private string $uuid;

    /**
     * @param string|null $uuid
     */
    public function __construct(?string $uuid)
    {
        if ($uuid === null) {
            throw new InvalidArgumentException('ID is null');
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
     * @return self
     */
    public static function create(?string $uuid): self
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4()->toString();
        }
        return new self($uuid);
    }
}
