<?php

declare(strict_types=1);

namespace Fulll\Infra\Console;

use Fulll\App\Service\Factory\RegisterVehicleServiceFactory;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\UserId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateFleetConsoleCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('create')
            ->setDescription('Creates a new fleet for the given userId.')
            ->addArgument('userId', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $timestamps = (new \DateTime('now'))->format('YmdHisu');
        $fleetId = "fleetId_CliCommand_" . $timestamps;

        $registerVehicleService = RegisterVehicleServiceFactory::withInDatabasePersistance();

        $registerVehicleService->createFleet(
            new FleetId($fleetId),
            new UserId($input->getArgument('userId'))
        );

        $output->writeln($fleetId);

        return Command::SUCCESS;
    }
}
