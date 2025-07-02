<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\UserId;
use Ramsey\Uuid\UuidInterface;

readonly final class CreateFleetCommand
{
    public function __construct(private UuidInterface $fleetId, private UserId $userId)
    {
    }

    public function getFleetId(): UuidInterface
    {
        return $this->fleetId;
    }


    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
