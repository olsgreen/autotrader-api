<?php


namespace Olsgreen\AutoTrader\Api\Builders;


use Olsgreen\AutoTrader\Api\Enums\OwnershipConditions;
use Olsgreen\AutoTrader\Api\Enums\VehicleTypes;

class VehicleInfoBuilder extends AbstractBuilder
{
    protected $registration;

    protected $derivativeId;

    protected $make;

    protected $model;

    protected $vehicleType;

    protected $ownershipCondition;

    protected $odometerReadingMiles;

    protected $colour;

    protected $requiredAttributes = [
        'registration',
        'derivativeId',
        'make',
        'model',
        'vehicleType',
        'ownershipCondition',
        'odometerReadingMiles',
    ];

    public function setRegistration(string $registration)
    {
        $this->registration = $registration;

        return $this;
    }

    public function getRegistration():? string
    {
        return $this->registration;
    }

    public function setDerivativeId(string $derivativeId): VehicleInfoBuilder
    {
        $this->derivativeId = $derivativeId;

        return $this;
    }

    public function getDerivativeId():? string
    {
        return $this->derivativeId;
    }

    public function setMake(string $make)
    {
        $this->make = $make;

        return $this;
    }

    public function getMake():? string
    {
        return $this->make;
    }

    public function setModel(string $model): VehicleInfoBuilder
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(string $model): string
    {
        return $this->model;
    }

    public function setVehicleType(string $type): VehicleInfoBuilder
    {
        $types = new VehicleTypes();

        if (!$types->contains($type)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid type.', $type)
            );
        }

        $this->vehicleType = $type;

        return $this;
    }

    public function getVehicleType(): string
    {
        return $this->vehicleType;
    }

    public function setOwnershipCondition(string $condition): VehicleInfoBuilder
    {
        $conditions = new OwnershipConditions();

        if (!$conditions->contains($condition)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid condition.', $condition)
            );
        }

        $this->ownershipCondition = $condition;

        return $this;
    }

    public function getOwnershipCondition():? string
    {
        return $this->ownershipCondition;
    }

    public function setOdometerReadingMiles(int $miles): VehicleInfoBuilder
    {
        $this->odometerReadingMiles = $miles;

        return $this;
    }

    public function getOdometerReadingMiles(): int
    {
        return $this->odometerReadingMiles;
    }

    public function setColour(string $colour): VehicleInfoBuilder
    {
        $this->colour = $colour;

        return $this;
    }

    public function getColour():? string
    {
        return $this->colour;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'registration' => $this->registration,
            'derivativeId' => $this->derivativeId,
            'make' => $this->make,
            'model' => $this->model,
            'colour' => $this->colour,
            'vehicleType' => $this->vehicleType,
            'ownershipCondition' => $this->ownershipCondition,
            'odometerReadingMiles' => $this->odometerReadingMiles,
        ]);
    }
}