<?php

namespace Fulll\Infra\DatabaseRepository;

use Fulll\App\Interface\VehicleRepository;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\VehicleId;
use Fulll\Infra\DatabaseEntity\VehicleEntity;

class InDatabaseVehicleRepository extends Connection implements VehicleRepository
{

    public function create(Vehicle $vehicle): void
    {
        $vehicleEntity = VehicleEntity::createFromModel($vehicle);

        $this->entityManager->persist($vehicleEntity);
        $this->entityManager->flush();
    }

    public function parkAt(Vehicle $vehicle): void
    {
        $vehicleEntity = $this->entityManager
            ->getRepository(VehicleEntity::class)
            ->find($vehicle->getId()->getValue());

        $vehicleEntity->parkAt($vehicle);

        $this->entityManager->persist($vehicleEntity);
        $this->entityManager->flush();
    }

    public function findById(VehicleId $id): ?Vehicle
    {
        $entity = $this->entityManager
            ->getRepository(VehicleEntity::class)
            ->findOneBy(['id' => $id->getValue()]);

        if(!$entity) {
            return null;
        }

        return $entity->mapToModel();
    }
}