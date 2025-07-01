<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

use InvalidArgumentException;

readonly final class VehicleId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Vehicle ID cannot be empty');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(VehicleId $vehicleId): bool
    {
        return $this->value === $vehicleId->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
