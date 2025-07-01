<?php

declare(strict_types=1);

namespace Fulll\Infra\DatabaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Exception\EntityMappingException;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\UserId;
use Fulll\Domain\ValueObject\VehicleId;
use Throwable;

#[ORM\Entity]
#[ORM\Table(name: 'fleet')]
class FleetEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', unique: true)]
    private string $id;

    #[ORM\Column(name: 'owner_email', type: 'string')]
    private string $ownerEmail;

    /**
     * @var Collection<int, VehicleEntity>
     */
    #[ORM\ManyToMany(targetEntity: VehicleEntity::class, inversedBy: 'fleets', cascade: ['persist'])]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getOwnerEmail(): ?string
    {
        return $this->ownerEmail;
    }

    public function setOwnerEmail(string $ownerEmail): static
    {
        $this->ownerEmail = $ownerEmail;

        return $this;
    }

    /**
     * @return Collection<int, VehicleEntity>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(VehicleEntity $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
        }

        return $this;
    }

    public static function createFromModel(Fleet $model): FleetEntity
    {
        try {
            $entity = new FleetEntity();
            $entity->setId($model->getId()->getValue());
            $entity->setOwnerEmail($model->getUserId()->getValue());

            foreach($model->getVehiclesList() as $vehicle) {
                $entity->addVehicle(VehicleEntity::createFromModel($vehicle));
            }

            return $entity;
        } catch (Throwable $e) {
            throw new EntityMappingException(
                'Can not create Fleet Entity FROM Fleet Model. Original message : ' . $e->getMessage()
            );
        }
    }

    public function mapToModel(): Fleet
    {
        try {
            $model = new Fleet(new FleetId($this->id), new UserId($this->ownerEmail));

            foreach($this->getVehicles() as $vehicleEntity) {
                $vehicleModel = new Vehicle(new VehicleId($vehicleEntity->getId()));
                if($vehicleEntity->hasCurrentLocation()) {
                    $location = new Location(
                        $vehicleEntity->getLat(),
                        $vehicleEntity->getLng(),
                        $vehicleEntity->getAlt()
                    );
                    $vehicleModel->parkAt($location);
                }

                $model->registerVehicle($vehicleModel);
            }

            return $model;
        } catch (Throwable $e) {
            throw new EntityMappingException(
                'Can not map Fleet Entity TO Fleet Model. Original message : ' . $e->getMessage()
            );
        }
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}