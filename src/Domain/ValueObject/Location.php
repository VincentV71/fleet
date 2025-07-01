<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

readonly final class Location
{
    public function __construct(
        private float $latitude,
        private float $longitude,
        private ?int $altitude = null
    ) {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): ?int
    {
        return $this->altitude;
    }

    public function equals(Location $location): bool
    {
        return $this->latitude === $location->getLatitude()
            && $this->longitude === $location->getLongitude()
            && $this->altitude === $location->getAltitude();
    }

    public function __toString(): string
    {
        return 'Lat : ' . $this->latitude . ', Lng : ' . $this->longitude. ', Alt : ' . ($this->altitude ?? 'NULL');
    }
}
