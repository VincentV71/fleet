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

final class LocalizeVehicleConsoleCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('localize-vehicle')
            ->setDescription('Returns location of a vehicle.')
            ->addArgument('fleetId', InputArgument::REQUIRED)
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vehicleId = new VehicleId($input->getArgument('vehiclePlateNumber'));
        $registerVehicleService = RegisterVehicleServiceFactory::withInDatabasePersistance();

        $vehicle = $registerVehicleService->getVehicleById($vehicleId);

        if ($location = $vehicle->getCurrentLocation()) {
            $output->write((string)$location->getLatitude());
            $output->write(' ' . $location->getLongitude());

            if ($alt = $location->getAltitude()) {
                $output->write(' ' . $alt);
            }
        } else {
            $output->write('Vehicle has no location yet.' );
        }

        return Command::SUCCESS;
    }
}
