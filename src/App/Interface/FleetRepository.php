<?php

declare(strict_types=1);

namespace Fulll\App\Interface;

use Fulll\Domain\AggregateRoot\Fleet;
use Fulll\Domain\ValueObject\FleetId;

interface FleetRepository
{
    public function create(Fleet $fleet): void;
    public function update(Fleet $fleet): void;
    public function findById(FleetId $id): ?Fleet;
}
