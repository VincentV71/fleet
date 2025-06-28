<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\UserId;

readonly final class CreateFleetCommand
{
    public function __construct(private FleetId $fleetId, private UserId $userId)
    {
    }

    public function getFleetId(): FleetId
    {
        return $this->fleetId;
    }


    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
