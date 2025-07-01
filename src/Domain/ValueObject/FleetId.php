<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

use InvalidArgumentException;

readonly final class FleetId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Fleet ID cannot be empty');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(FleetId $fleetId): bool
    {
        return $this->value === $fleetId->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
