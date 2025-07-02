<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepository;
use Fulll\App\Interface\VehicleRepository;
use InvalidArgumentException;

readonly final class RegisterVehicleCommandHandler
{
    public function __construct(
        private FleetRepository   $fleetRepository,
        private VehicleRepository $vehicleRepository
    ) {
    }

    public function handle(RegisterVehicleCommand $command): void
    {
        $fleet = $this->fleetRepository->findById($command->getFleetId());
        if (!$fleet) {
            throw new InvalidArgumentException(
                sprintf('Fleet "%s" not found', $command->getFleetId()->toString())
            );
        }

        $vehicle = $this->vehicleRepository->findById($command->getVehicleId());
        if (!$vehicle) {
            throw new InvalidArgumentException(sprintf('Vehicle "%s" not found', $command->getVehicleId()));
        }

        $fleet->registerVehicle($vehicle);

        $this->fleetRepository->registerVehicle($fleet, $vehicle);
    }
}
