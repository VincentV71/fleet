<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\App\Interface\VehicleRepository;
use Fulll\Domain\Model\Vehicle;

readonly final class FindVehicleByIdQueryHandler
{
    public function __construct(private VehicleRepository $vehicleRepository)
    {
    }

    public function handle(FindVehicleByIdQuery $query): ?Vehicle
    {
        return $this->vehicleRepository->findById($query->getVehicleId());
    }
}
