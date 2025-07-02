<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

use Fulll\Domain\ValueObject\VehicleId;
use Ramsey\Uuid\UuidInterface;

class VehicleAlreadyRegisteredInFleetException extends \Exception
{
    public function __construct(VehicleId $vehicleId, UuidInterface $fleetId)
    {
        parent::__construct(
            sprintf('Vehicle %s has already been registered into fleet %s', $vehicleId, $fleetId->toString())
        );
    }
}
