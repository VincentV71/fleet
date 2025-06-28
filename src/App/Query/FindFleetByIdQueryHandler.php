<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\App\Interface\FleetRepository;
use Fulll\Domain\AggregateRoot\Fleet;

readonly final class FindFleetByIdQueryHandler
{
    public function __construct(private FleetRepository $fleetRepository)
    {
    }

    public function handle(FindFleetByIdQuery $query): ?Fleet
    {
        return $this->fleetRepository->findById($query->getFleetId());
    }
}
