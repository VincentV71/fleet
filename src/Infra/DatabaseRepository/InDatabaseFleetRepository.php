<?php

namespace Fulll\Infra\DatabaseRepository;

use Doctrine\ORM\EntityManager;
use Fulll\App\Interface\FleetRepository;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Infra\DatabaseEntity\FleetEntity;
use Fulll\Infra\DatabaseEntity\VehicleEntity;

class InDatabaseFleetRepository implements FleetRepository
{
    private EntityManager $entityManager;

    public function __construct()
    {
        $this->entityManager = Database::getEntityManager();
    }

    public function create(Fleet $fleet): void
    {
        $fleetEntity = FleetEntity::createFromModel($fleet);
        $this->entityManager->persist($fleetEntity);
        $this->entityManager->flush();
    }

    public function registerVehicle(Fleet $fleet, Vehicle $vehicle): void
    {
        $fleetEntity = $this->entityManager
            ->getRepository(FleetEntity::class)
            ->find($fleet->getId()->getValue());

        $vehicleEntity = $this->entityManager
            ->getRepository(VehicleEntity::class)
            ->find($vehicle->getId()->getValue());

        $fleetEntity->addVehicle($vehicleEntity);

        $this->entityManager->persist($fleetEntity);
        $this->entityManager->flush();
    }

    public function findById(FleetId $id): ?Fleet
    {
        $entity = $this->entityManager
            ->getRepository(FleetEntity::class)
            ->find($id->getValue());

        if(!$entity) {
            return null;
        }

        return $entity->mapToModel();
    }
}
