<?php

declare(strict_types=1);

namespace Fulll\App\Service\Factory;

use Fulll\App\Command\CreateFleetCommandHandler;
use Fulll\App\Command\CreateVehicleCommandHandler;
use Fulll\App\Command\RegisterVehicleCommandHandler;
use Fulll\App\Query\FindFleetByIdQueryHandler;
use Fulll\App\Query\FindVehicleByIdQueryHandler;
use Fulll\App\Service\RegisterVehicleService;
use Fulll\Infra\DatabaseRepository\InDatabaseFleetRepository;
use Fulll\Infra\DatabaseRepository\InDatabaseVehicleRepository;
use Fulll\Infra\InMemoryRepository\InMemoryFleetRepository;
use Fulll\Infra\InMemoryRepository\InMemoryVehicleRepository;

class RegisterVehicleServiceFactory
{
    public static function withInMemoryPersistance(): RegisterVehicleService
    {
        $fleetRepository = new InMemoryFleetRepository();
        $vehicleRepository = new InMemoryVehicleRepository();

        return new RegisterVehicleService(
            new RegisterVehicleCommandHandler($fleetRepository, $vehicleRepository),
            new CreateVehicleCommandHandler($vehicleRepository),
            new CreateFleetCommandHandler($fleetRepository),
            new FindVehicleByIdQueryHandler($vehicleRepository),
            new FindFleetByIdQueryHandler($fleetRepository),
        );
    }

    public static function withInDatabasePersistance(): RegisterVehicleService
    {
        $fleetRepository = new InDatabaseFleetRepository();
        $vehicleRepository = new InDatabaseVehicleRepository();

        return new RegisterVehicleService(
            new RegisterVehicleCommandHandler($fleetRepository, $vehicleRepository),
            new CreateVehicleCommandHandler($vehicleRepository),
            new CreateFleetCommandHandler($fleetRepository),
            new FindVehicleByIdQueryHandler($vehicleRepository),
            new FindFleetByIdQueryHandler($fleetRepository),
        );
    }
}
