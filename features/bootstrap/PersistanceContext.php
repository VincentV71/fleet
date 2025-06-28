<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Command\CreateFleetCommandHandler;
use Fulll\App\Command\CreateVehicleCommandHandler;
use Fulll\App\Command\ParkVehicleCommandHandler;
use Fulll\App\Command\RegisterVehicleCommandHandler;
use Fulll\App\Query\FindFleetByIdQueryHandler;
use Fulll\App\Query\FindVehicleByIdQueryHandler;
use Fulll\App\Service\ParkVehicleService;
use Fulll\App\Service\RegisterVehicleService;
use Fulll\Infra\InMemoryRepository\InMemoryFleetRepository;
use Fulll\Infra\InMemoryRepository\InMemoryVehicleRepository;

class PersistanceContext implements Context
{
    readonly protected RegisterVehicleService $registerVehiculeService;

    readonly protected ParkVehicleService $parkVehicleService;

    public function __construct()
    {
        $fleetRepository = new InMemoryFleetRepository();
        $vehicleRepository = new InMemoryVehicleRepository();

        $this->registerVehiculeService = new RegisterVehicleService(
            new RegisterVehicleCommandHandler($fleetRepository, $vehicleRepository),
            new CreateVehicleCommandHandler($vehicleRepository),
            new CreateFleetCommandHandler($fleetRepository),
            new FindVehicleByIdQueryHandler($vehicleRepository),
            new FindFleetByIdQueryHandler($fleetRepository),
        );

        $this->parkVehicleService = new ParkVehicleService(
            new ParkVehicleCommandHandler($vehicleRepository),
        );
    }
}

