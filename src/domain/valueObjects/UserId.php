<?php declare(strict_types=1);

namespace omarinina\domain\valueObjects;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class UserId
{
    /** @var integer */
    private int $id;

    /**
     * @param integer|null $id
     */
    public function __construct(?int $id)
    {
        if ($id === null) {
            throw new InvalidArgumentException('ID is null');
        }

        Assert::integer($id);

        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer|null $id
     * @return self
     */
    public static function create(?int $id): self
    {
        if ($id === null) {
            $id = rand();
        }
        return new self($id);
    }
}
