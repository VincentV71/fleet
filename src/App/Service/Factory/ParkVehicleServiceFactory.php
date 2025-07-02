<?php

declare(strict_types=1);

namespace Fulll\App\Service\Factory;

use Fulll\App\Command\ParkVehicleCommandHandler;
use Fulll\App\Interface\VehicleRepository;
use Fulll\App\Service\ParkVehicleService;
use Fulll\Infra\DatabaseRepository\InDatabaseVehicleRepository;
use Fulll\Infra\InMemoryRepository\InMemoryVehicleRepository;

class ParkVehicleServiceFactory
{
    public static function withInMemoryPersistance(): ParkVehicleService
    {
        return self::createService(new InMemoryVehicleRepository());
    }

    public static function withInDatabasePersistance(): ParkVehicleService
    {
        return self::createService(new InDatabaseVehicleRepository());
    }

    private static function createService(VehicleRepository $vehicleRepository): ParkVehicleService
    {
        return new ParkVehicleService(
            new ParkVehicleCommandHandler($vehicleRepository)
        );
    }
}
