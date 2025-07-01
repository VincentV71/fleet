<?php

declare(strict_types=1);

namespace Fulll\App\Service;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\CreateFleetCommandHandler;
use Fulll\App\Command\CreateVehicleCommand;
use Fulll\App\Command\CreateVehicleCommandHandler;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\Command\RegisterVehicleCommandHandler;
use Fulll\App\Query\FindFleetByIdQuery;
use Fulll\App\Query\FindFleetByIdQueryHandler;
use Fulll\App\Query\FindVehicleByIdQuery;
use Fulll\App\Query\FindVehicleByIdQueryHandler;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\UserId;
use Fulll\Domain\ValueObject\VehicleId;

readonly final class RegisterVehicleService
{
    public function __construct(
        private RegisterVehicleCommandHandler   $registerVehicleHandler,
        private CreateVehicleCommandHandler     $createVehicleCommandHandler,
        private CreateFleetCommandHandler       $createFleetCommandHandler,
        private FindVehicleByIdQueryHandler     $findVehicleByIdQueryHandler,
        private FindFleetByIdQueryHandler       $findFleetByIdQueryHandler,
    ) {
    }

    public function createFleet(FleetId $fleetId, UserId $userId): void
    {
        $this->createFleetCommandHandler->handle(new CreateFleetCommand($fleetId, $userId));
    }

    public function createVehicle(VehicleId $vehicleId): void
    {
        $this->createVehicleCommandHandler->handle(new CreateVehicleCommand($vehicleId));
    }

    public function getVehicleById(VehicleId $vehicleId): ?Vehicle
    {
        return $this->findVehicleByIdQueryHandler->handle(new FindVehicleByIdQuery($vehicleId)) ?? null;
    }

    public function getFleetById(FleetId $fleetId): ?Fleet
    {
        return $this->findFleetByIdQueryHandler->handle(new FindFleetByIdQuery($fleetId)) ?? null;
    }

    public function registerVehicle(FleetId $fleetId, VehicleId $vehicleId): void
    {
        $this->registerVehicleHandler->handle(new RegisterVehicleCommand($fleetId, $vehicleId));
    }
}
