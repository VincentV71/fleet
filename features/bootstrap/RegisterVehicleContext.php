<?php

declare(strict_types=1);

use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;
use Fulll\Domain\ValueObject\UserId;
use Fulll\Domain\ValueObject\VehicleId;
use Ramsey\Uuid\Rfc4122\UuidV7;

class RegisterVehicleContext extends PersistanceContext
{
    private ?string $exceptionMessage = null;

    #[Given('my fleet named :fleetId')]
    public function myFleetNamed($fleetId): void
    {
        $this->registerVehiculeService->createFleet(
            UuidV7::fromString($fleetId),
            new UserId($this->generateMail($fleetId)),
        );
    }

    #[Given('a vehicle named :vehicleId')]
    public function aVehicleNamed($vehicleId): void
    {
        $this->registerVehiculeService->createVehicle(new VehicleId($vehicleId));
    }

    #[When('I register this vehicle named :vehicleId into my fleet named :fleetId')]
    public function iRegisterThisVehicleIntoMyFleet($vehicleId, $fleetId): void
    {
        try {
            $this->registerVehiculeService->registerVehicle(
                UuidV7::fromString($fleetId),
                new VehicleId($vehicleId)
            );
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    #[Then('this vehicle named :vehicleId should be part of my vehicle fleet named :fleetId')]
    public function thisVehicleShouldBePartOfMyVehicleFleet($vehicleId, $fleetId): void
    {
        $fleet = $this->registerVehiculeService->getFleetById(UuidV7::fromString($fleetId));
        $vehicle = $this->registerVehiculeService->getVehicleById(new VehicleId($vehicleId));

        if(!$fleet || !$vehicle || !$fleet->hasVehicle($vehicle->getId())) {
            throw new Exception(sprintf('Vehicle "%s" should be part of fleet "%s"', $vehicleId, $fleetId));
        }
    }

    #[Given('I have registered this vehicle named :vehicleId into my fleet named :fleetId')]
    public function iHaveRegisteredThisVehicleIntoMyFleet($vehicleId, $fleetId): void
    {
        $fleet = $this->registerVehiculeService->getFleetById(UuidV7::fromString($fleetId));
        $vehicle = $this->registerVehiculeService->getVehicleById(new VehicleId($vehicleId));

        if(!$fleet || !$vehicle) {
            throw new Exception(sprintf('Vehicle "%s" or fleet "%s" not found', $vehicleId, $fleetId));
        }

        if(!$fleet->hasVehicle($vehicle->getId())) {
            $this->iRegisterThisVehicleIntoMyFleet($vehicleId, $fleetId);
        }
    }

    #[When('I try to register this vehicle named :vehicleId into my fleet named :fleetId')]
    public function iTryToRegisterThisVehicleIntoMyFleet($vehicleId, $fleetId): void
    {
        $this->exceptionMessage = null;

        try {
            $this->iRegisterThisVehicleIntoMyFleet($vehicleId, $fleetId);
        } catch (Throwable $e) {
            $this->exceptionMessage = $e->getMessage();
        }
    }

    #[Then('I should be informed this this vehicle named :vehicleId has already been registered into my fleet named :fleetId')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet($vehicleId, $fleetId): void
    {
        $expectedException = new VehicleAlreadyRegisteredInFleetException(
            new VehicleId($vehicleId),
            UuidV7::fromString($fleetId)
        );

        if($expectedException->getMessage() !== $this->exceptionMessage) {
            throw new Exception(sprintf('Fails to display that : "%s"', $expectedException->getMessage()));
        }

        $this->exceptionMessage = null;
    }

    #[Given('the fleet of another user named :fleetId')]
    public function theFleetOfAnotherUser($fleetId): void
    {
        $this->registerVehiculeService->createFleet(
            UuidV7::fromString($fleetId),
            new UserId($this->generateMail($fleetId))
        );
    }

    #[Given('this vehicle named :vehicleId has been registered into the other user\'s fleet named :fleetId')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet($vehicleId, $fleetId): void
    {
        $this->iHaveRegisteredThisVehicleIntoMyFleet($vehicleId, $fleetId);
    }

    private function generateMail(string $fleetId): string
    {
        return $fleetId . "@gmail.com";
    }
}
