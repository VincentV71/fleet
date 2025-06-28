<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\VehicleId;

interface VehicleRepository
{
    public function create(Vehicle $vehicle): void;
    public function update(Vehicle $vehicle): void;
    public function findById(VehicleId $id): ?Vehicle;
}
