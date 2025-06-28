<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;

final readonly class ParkVehicleCommand
{
    public function __construct(
        private VehicleId $vehicleId,
        private Location $location
    ) {
    }

    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
