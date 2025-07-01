<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

use InvalidArgumentException;

readonly final class UserId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('User ID cannot be empty');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(UserId $userId): bool
    {
        return $this->value === $userId->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
