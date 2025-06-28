<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Domain\ValueObject\FleetId;

readonly final class FindFleetByIdQuery
{
    public function __construct(private FleetId $fleetId)
    {
    }

    public function getFleetId(): FleetId
    {
        return $this->fleetId;
    }
}
