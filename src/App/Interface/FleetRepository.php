<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;

interface FleetRepository
{
    public function create(Fleet $fleet): void;
    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void;
    public function findById(FleetId $id): ?Fleet;
}
