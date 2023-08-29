<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\VehicleTypes;

class TaxonomyFacetRequestBuilder extends AbstractBuilder
{
    protected $vehicleType;

    protected $makeId;

    protected $modelId;

    protected $generationId;

    public function getVehicleType(): ?string
    {
        return $this->vehicleType;
    }

    public function setVehicleType(string $vehicleType): TaxonomyFacetRequestBuilder
    {
        $typesList = new VehicleTypes();

        if (!$typesList->contains($vehicleType)) {
            throw new \Exception(
                sprintf(
                    'You tried to set invalid vehicle type. [%s]',
                    $vehicleType
                )
            );
        }

        $this->vehicleType = $vehicleType;

        return $this;
    }

    public function getMakeId(): ?string
    {
        return $this->makeId;
    }

    public function setMakeId(string $makeId): TaxonomyFacetRequestBuilder
    {
        $this->makeId = $makeId;

        return $this;
    }

    public function getModelId(): ?string
    {
        return $this->modelId;
    }

    public function setModelId(string $modelId): TaxonomyFacetRequestBuilder
    {
        $this->modelId = $modelId;

        return $this;
    }

    public function getGenerationId(): ?string
    {
        return $this->generationId;
    }

    public function setGenerationId(string $generationId): TaxonomyFacetRequestBuilder
    {
        $this->generationId = $generationId;

        return $this;
    }

    public function validate(): bool
    {
        $setKeys = array_filter(['vehicleType', 'makeId', 'modelId', 'generationId'], function ($key) {
            return !empty($this->$key);
        });

        if (empty($setKeys)) {
            throw new \InvalidArgumentException(
                'You must specify one of the following vehicleType, makeId, modelId, generationId.'
            );
        }

        return parent::validate();
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicleType'  => $this->vehicleType,
            'makeId'       => $this->makeId,
            'modelId'      => $this->modelId,
            'generationId' => $this->generationId,
        ]);
    }
}
