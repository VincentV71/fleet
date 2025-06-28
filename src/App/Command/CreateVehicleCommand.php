<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\VehicleId;

readonly final class CreateVehicleCommand
{
    public function __construct(private VehicleId $vehicleId)
    {
    }

    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }
}
