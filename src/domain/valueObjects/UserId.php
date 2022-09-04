<?php declare(strict_types=1);

namespace omarinina\domain\valueObjects;

use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class UserId
{
    private string $id;

    public function __construct(?string $id)
    {
        if ($id === null) {
            throw new InvalidArgumentException('ID is null');
        }

        Assert::uuid($id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function create(?string $id = null): self
    {
        if ($id) {
            $id = '';
        }
        return new self($id);
    }
}
