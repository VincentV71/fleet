<?php

declare(strict_types=1);

namespace Fulll\Domain\AggregateRoot;

use Fulll\Domain\Exception\VehicleAlreadyRegisteredException;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\UserId;
use Fulll\Domain\ValueObject\VehicleId;

class Fleet
{
    private array $vehicles = []; // [VehicleId -> Vehicle, ...]

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
            throw new VehicleAlreadyRegisteredException($vehicleId, $this->id);
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

    public function getVehicles(): array
    {
        return array_values($this->vehicles);
    }
}
