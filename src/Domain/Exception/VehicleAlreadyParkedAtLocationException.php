<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;

class VehicleAlreadyParkedAtLocationException extends \Exception
{
    public function __construct(VehicleId $vehicleId, Location $location)
    {
        parent::__construct(
            sprintf('Vehicle "%s" is already parked at location : "%s"', $vehicleId, $location)
        );
    }
}
