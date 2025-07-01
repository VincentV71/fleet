<?php

declare(strict_types=1);

namespace Fulll\Infra\InMemoryRepository;

use Fulll\App\Interface\FleetRepository;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;

class InMemoryFleetRepository implements FleetRepository
{
    public static array $fleets = [];

    public function create(Fleet $fleet): void
    {
        self::$fleets[$fleet->getId()->getValue()] = $fleet;
    }

    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
        self::$fleets[$fleet->getId()->getValue()] = $fleet;
    }

    public function findById(FleetId $id): ?Fleet
    {
        return self::$fleets[$id->getValue()] ?? null;
    }
}
