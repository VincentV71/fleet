<?php

declare(strict_types=1);

namespace Fulll\App\Service\Factory;

use Fulll\App\Command\ParkVehicleCommandHandler;
use Fulll\App\Service\ParkVehicleService;
use Fulll\Infra\DatabaseRepository\InDatabaseVehicleRepository;
use Fulll\Infra\InMemoryRepository\InMemoryVehicleRepository;

class ParkVehicleServiceFactory
{
    public static function withInMemoryPersistance(): ParkVehicleService
    {
        return new ParkVehicleService(
            new ParkVehicleCommandHandler(new InMemoryVehicleRepository())
        );
    }

    public static function withInDatabasePersistance(): ParkVehicleService
    {
        return new ParkVehicleService(
            new ParkVehicleCommandHandler(new InDatabaseVehicleRepository())
        );
    }
}
