<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;

class Vehicle
{
    private VehicleId $id;
    private ?Location $currentLocation = null;

    public function __construct(VehicleId $id)
    {
        $this->id = $id;
    }

    public function getId(): VehicleId
    {
        return $this->id;
    }

    public function getCurrentLocation(): ?Location
    {
        return $this->currentLocation;
    }

    public function parkAt(Location $location): void
    {
        if ($this->currentLocation && $this->currentLocation->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException($this->id, $location);
        }

        $this->currentLocation = $location;
    }
}
