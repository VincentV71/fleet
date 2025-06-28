<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\VehicleRepository;
use InvalidArgumentException;

readonly final class ParkVehicleCommandHandler
{

    public function __construct(private VehicleRepository $vehicleRepository)
    {
    }

    public function handle(ParkVehicleCommand $command): void
    {
        $vehicle = $this->vehicleRepository->findById($command->getVehicleId());
        if (!$vehicle) {
            throw new InvalidArgumentException('Vehicle not found');
        }

        $vehicle->parkAt($command->getLocation());
        $this->vehicleRepository->update($vehicle);
    }
}
