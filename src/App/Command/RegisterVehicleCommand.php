<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\VehicleId;
use Ramsey\Uuid\UuidInterface;

final readonly class RegisterVehicleCommand
{
    public function __construct(private UuidInterface $fleetId, private VehicleId $vehicleId) {
    }

    public function getFleetId(): UuidInterface
    {
        return $this->fleetId;
    }

    public function getVehicleId(): VehicleId
    {
        return $this->vehicleId;
    }
}
