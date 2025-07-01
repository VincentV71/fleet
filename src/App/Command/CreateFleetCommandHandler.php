<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\App\Interface\FleetRepository;
use Fulll\Domain\Model\Fleet;

readonly final class CreateFleetCommandHandler
{
    public function __construct(private FleetRepository $fleetRepository)
    {
    }

    public function handle(CreateFleetCommand $command): void
    {
        if (!$this->fleetRepository->findById($command->getFleetId())) {
            $fleet = new Fleet($command->getFleetId(), $command->getUserId());
            $this->fleetRepository->create($fleet);
        }
    }
}
