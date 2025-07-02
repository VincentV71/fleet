<?php

declare(strict_types=1);

namespace Fulll\Infra\DatabaseEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Exception\EntityMappingException;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;
use Throwable;

#[ORM\Entity]
#[ORM\Table(name: 'vehicle')]
class VehicleEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', unique: true)]
    private string $id;

    #[ORM\Column(name: 'lat', nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(name: 'lng', nullable: true)]
    private ?float $lng = null;

    #[ORM\Column(name: 'alt', nullable: true)]
    private ?int $alt = null;

    /**
     * @var Collection<int, FleetEntity>
     */
    #[ORM\ManyToMany(targetEntity: FleetEntity::class, mappedBy: 'vehicles', cascade: ['persist'])]
    private Collection $fleets;

    public function __construct()
    {
        $this->fleets = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): static
    {
        $this->lng = $lng;

        return $this;
    }

    public function getAlt(): ?int
    {
        return $this->alt;
    }

    public function setAlt(?int $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return Collection<int, FleetEntity>
     */
    public function getFleets(): Collection
    {
        return $this->fleets;
    }

    public function addFleet(FleetEntity $fleet): static
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets->add($fleet);
            $fleet->addVehicle($this);
        }

        return $this;
    }

    public function hasCurrentLocation(): bool
    {
        return $this->getLat() && $this->getLng();
    }

    /**
     * Create a new VehicleEntity from a Vehicle Model
     * @param Vehicle $model
     * @return VehicleEntity
     * @throws EntityMappingException
     */
    public static function createFromModel(Vehicle $model): VehicleEntity
    {
        try {
            $entity = new VehicleEntity();
            $entity->setId($model->getId()->getValue());

            if($location = $model->getCurrentLocation()) {
                $entity->setLat($location->getLatitude());
                $entity->setLng($location->getLongitude());
                $entity->setAlt($location->getAltitude());
            }

            return $entity;
        } catch (Throwable $e) {
            throw new EntityMappingException(
            'Can not create Vehicle Entity FROM Vehicle Model. Original message : ' . $e->getMessage()
            );
        }
    }

    /**
     * Register VehicleEntity location from the Vechicle Model Location
     * @param Vehicle $model
     * @return $this
     * @throws EntityMappingException
     */
    public function parkAt(Vehicle $model): VehicleEntity
    {
        try {
            if($location = $model->getCurrentLocation()) {
                $this->setLat($location->getLatitude());
                $this->setLng($location->getLongitude());
                $this->setAlt($location->getAltitude());
            }

            return $this;
        } catch (Throwable $e) {
            throw new EntityMappingException(
                'Can not park Vehicle Entity FROM Vehicle Model. Original message : ' . $e->getMessage()
            );
        }
    }

    /**
     * Instantiate a Vehicle Model from a VehicleEntity
     * @return Vehicle
     * @throws EntityMappingException
     */
    public function mapToModel(): Vehicle
    {
        try {
            $model = new Vehicle(new VehicleId($this->id));

            if ($this->hasCurrentLocation()) {
                $location = new Location($this->getLat(), $this->getLng(), $this->getAlt());
                $model->parkAt($location);
            }

            return $model;
        } catch (Throwable $e) {
            throw new EntityMappingException(
                'Can not map Vehicle Entity TO Vehicle Model. Original message : ' . $e->getMessage()
            );
        }
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}