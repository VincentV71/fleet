<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\UserId;
use Fulll\Domain\ValueObject\VehicleId;

class Fleet
{
    private array $vehicles = []; // [vehicleId -> Vehicle Model, ...]

    public function __construct(
        private readonly FleetId $id,
        private readonly UserId $userId
    ) {
    }

    public function getId(): FleetId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function registerVehicle(Vehicle $vehicle): void
    {
        $vehicleId = $vehicle->getId();

        if (isset($this->vehicles[$vehicleId->getValue()])) {
            throw new VehicleAlreadyRegisteredInFleetException($vehicleId, $this->id);
        }

        $this->vehicles[$vehicleId->getValue()] = $vehicle;
    }

    public function hasVehicle(VehicleId $vehicleId): bool
    {
        return isset($this->vehicles[$vehicleId->getValue()]);
    }

    public function getVehicle(VehicleId $vehicleId): ?Vehicle
    {
        return $this->vehicles[$vehicleId->getValue()] ?? null;
    }

    public function getVehiclesList(): array
    {
        return $this->vehicles;
    }
}
