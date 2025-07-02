<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Ramsey\Uuid\UuidInterface;

interface FleetRepository
{
    public function create(Fleet $fleet): void;
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void;
    public function findById(UuidInterface $id): ?Fleet;
}
