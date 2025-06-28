<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\VehicleRepository;
use Fulll\Domain\Model\Vehicle;

readonly final class CreateVehicleCommandHandler
{
    public function __construct(private VehicleRepository $vehicleRepository)
    {
    }

    public function handle(CreateVehicleCommand $command): void
    {
        if (!$this->vehicleRepository->findById($command->getVehicleId())) {
            $vehicle = new Vehicle($command->getVehicleId());
            $this->vehicleRepository->create($vehicle);
        }
    }
}
