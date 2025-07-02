<?php

declare(strict_types=1);

namespace Fulll\Infra\InMemoryRepository;

use Fulll\App\Interface\FleetRepository;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Ramsey\Uuid\UuidInterface;

class InMemoryFleetRepository implements FleetRepository
{
    public static array $fleets = [];

    public function create(Fleet $fleet): void
    {
        self::$fleets[$fleet->getId()->toString()] = $fleet;
    }

    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
        self::$fleets[$fleet->getId()->toString()] = $fleet;
    }

    public function findById(UuidInterface $id): ?Fleet
    {
        return self::$fleets[$id->toString()] ?? null;
    }
}
