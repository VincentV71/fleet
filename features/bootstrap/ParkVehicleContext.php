<?php

declare(strict_types=1);

use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\ValueObject\Location;
use Fulll\Domain\ValueObject\VehicleId;

class ParkVehicleContext extends PersistanceContext
{
    private ?string $exceptionMessage = null;

    #[Given('a location :lat :lng :alt')]
    public function aLocation($lat, $lng, $alt): void
    {
        // We don't need to persist a standalone Location.
    }

    #[When('I park my vehicle named :vehicleId at this location :lat :lng :alt')]
    public function iParkMyVehicleNamedAtThisLocation($vehicleId, $lat, $lng, $alt): void
    {
        try {
            $this->parkVehicleService->parkVehicle(
                new VehicleId($vehicleId),
                new Location((float)$lat, (float)$lng, (int)$alt)
            );
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    #[Then('the known location of my vehicle named :vehicleId should verify this location :lat :lng :alt')]
    public function theKnownLocationOfMyVehicleNamedShouldVerifyThisLocation($vehicleId, $lat, $lng, $alt): void
    {
        $vehicle = $this->registerVehiculeService->getVehicleById(new VehicleId($vehicleId));
        $location = new Location((float)$lat, (float)$lng, (int)$alt);

        if (!$vehicle->getCurrentLocation()->equals($location)) {
            throw new Exception(
                sprintf('Vehicle "%s" should be register at this location : "%s"', $vehicleId, $location));
        }
    }

    #[Given('my vehicle named :vehicleId has been parked into this location :lat :lng :alt')]
    public function myVehicleNamedHasBeenParkedIntoThisLocation($vehicleId, $lat, $lng, $alt): void
    {
        $vehicle = $this->registerVehiculeService->getVehicleById(new VehicleId($vehicleId));
        $location = new Location((float)$lat, (float)$lng, (int)$alt);

        if (!$vehicle->getCurrentLocation() || !$vehicle->getCurrentLocation()->equals($location)) {
            $this->iParkMyVehicleNamedAtThisLocation($vehicleId, $lat, $lng, $alt);
        }
    }

    #[When('I try to park my vehicle named :vehicleId at this location :lat :lng :alt')]
    public function iTryToParkMyVehicleNamedAtThisLocation($vehicleId, $lat, $lng, $alt): void
    {
        $this->exceptionMessage = null;

        try {
            $this->parkVehicleService->parkVehicle(
                new VehicleId($vehicleId),
                new Location((float)$lat, (float)$lng, (int)$alt)
            );
        } catch (Throwable $e) {
            $this->exceptionMessage = $e->getMessage();
        }
    }

    #[Then('I should be informed that my vehicle named :vehicleId is already parked at this location :lat :lng :alt')]
    public function iShouldBeInformedThatMyVehicleNamedIsAlreadyParkedAtThisLocation($vehicleId, $lat, $lng, $alt): void
    {
        $expectedException = new VehicleAlreadyParkedAtLocationException(
            new VehicleId($vehicleId),
            new Location((float)$lat, (float)$lng, (int)$alt)
        );

        if($expectedException->getMessage() !== $this->exceptionMessage) {
            throw new Exception(sprintf('Fails to display that : "%s"', $expectedException->getMessage()));
        }

        $this->exceptionMessage = null;
    }
}
