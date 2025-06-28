<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\VehicleId;

class VehicleAlreadyRegisteredException extends \Exception
{
    public function __construct(VehicleId $vehicleId, FleetId $fleetId)
    {
        parent::__construct(
            sprintf('Vehicle %s has already been registered into fleet %s', $vehicleId, $fleetId)
        );
    }
}
