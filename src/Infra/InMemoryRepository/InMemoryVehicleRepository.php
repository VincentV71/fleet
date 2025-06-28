<?php

declare(strict_types=1);

namespace Fulll\Infra\InMemoryRepository;

use Fulll\App\Interface\VehicleRepository;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\VehicleId;

class InMemoryVehicleRepository implements VehicleRepository
{
    public static array $vehicles = [];

    public function create(Vehicle $vehicle): void
    {
        self::$vehicles[$vehicle->getId()->getValue()] = $vehicle;
    }

    public function update(Vehicle $vehicle): void
    {
        self::$vehicles[$vehicle->getId()->getValue()] = $vehicle;
    }

    public function findById(VehicleId $id): ?Vehicle
    {
        return self::$vehicles[$id->getValue()] ?? null;
    }
}
