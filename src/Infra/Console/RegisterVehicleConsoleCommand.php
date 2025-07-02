<?php

declare(strict_types=1);

namespace Fulll\Infra\Console;

use Fulll\App\Service\Factory\RegisterVehicleServiceFactory;
use Fulll\Domain\ValueObject\VehicleId;
use Ramsey\Uuid\Rfc4122\UuidV7;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RegisterVehicleConsoleCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('register-vehicle')
            ->setDescription('Creates a new vehicle and register it in the given fleetId.')
            ->addArgument('fleetId', InputArgument::REQUIRED)
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fleetId = UuidV7::fromString($input->getArgument('fleetId'));
        $vehicleId = new VehicleId($input->getArgument('vehiclePlateNumber'));
        $registerVehicleService = RegisterVehicleServiceFactory::withInDatabasePersistance();

        $registerVehicleService->createVehicle($vehicleId);
        $registerVehicleService->registerVehicle($fleetId, $vehicleId);

        return Command::SUCCESS;
    }
}
