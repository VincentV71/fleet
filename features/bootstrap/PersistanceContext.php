<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Service\Factory\ParkVehicleServiceFactory;
use Fulll\App\Service\Factory\RegisterVehicleServiceFactory;
use Fulll\App\Service\ParkVehicleService;
use Fulll\App\Service\RegisterVehicleService;

class PersistanceContext implements Context
{
    readonly protected RegisterVehicleService $registerVehiculeService;

    readonly protected ParkVehicleService $parkVehicleService;

    public function __construct()
    {
        if (in_array('--tags=@in-db', $_SERVER['argv'] ?? [])) {
            $this->registerVehiculeService = RegisterVehicleServiceFactory::withInDatabasePersistance();
            $this->parkVehicleService = ParkVehicleServiceFactory::withInDatabasePersistance();
        } else {
            $this->registerVehiculeService = RegisterVehicleServiceFactory::withInMemoryPersistance();
            $this->parkVehicleService = ParkVehicleServiceFactory::withInMemoryPersistance();
        }
    }
}

