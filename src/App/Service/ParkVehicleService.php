<?php

declare(strict_types=1);

namespace Fulll\App\Service;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\ParkVehicleCommandHandler;
use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;

readonly final class ParkVehicleService
{
    public function __construct(private ParkVehicleCommandHandler $parkVehicleHandler)
    {
    }

    public function parkVehicle(VehicleId $vehicleId, Location $location): void
    {
        $this->parkVehicleHandler->handle(new ParkVehicleCommand($vehicleId, $location));
    }
}
