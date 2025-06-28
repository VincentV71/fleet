<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\VehicleId;

final readonly class RegisterVehicleCommand
{
    public function __construct(private FleetId $fleetId, private VehicleId $vehicleId) {
    }

    public function getFleetId(): FleetId
    {
        return $this->fleetId;
    }

    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }
}
