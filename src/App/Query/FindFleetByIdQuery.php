<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Ramsey\Uuid\UuidInterface;

readonly final class FindFleetByIdQuery
{
    public function __construct(private UuidInterface $fleetId)
    {
    }

    public function getFleetId(): UuidInterface
    {
        return $this->fleetId;
    }
}
