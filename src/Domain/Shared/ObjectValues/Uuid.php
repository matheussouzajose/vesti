<?php

namespace Core\Domain\Shared\ObjectValues;

use Core\Domain\Shared\Exception\UuidException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    /**
     * @throws UuidException
     */
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws UuidException
     */
    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    /**
     * @throws UuidException
     */
    private function ensureIsValid(string $id): void
    {
        if (! RamseyUuid::isValid($id)) {
            throw UuidException::itemInvalid($id);
        }
    }
}