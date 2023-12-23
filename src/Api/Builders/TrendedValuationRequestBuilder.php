<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\ValuationConditionTypes;

class TrendedValuationRequestBuilder extends AbstractBuilder
{
    protected $vehicle;

    protected $features;

    protected $condition;

    protected $valuations;

    public function __construct(array $attributes = [])
    {
        $this->vehicle = new TrendedValuationVehicleRequestBuilder($this->dataGet($attributes, 'vehicle', []));

        $this->features = new VehicleFeatureInfoBuilder($this->dataGet($attributes, 'features', []));

        $this->valuations = new TrendedValuationValuationsRequestBuilder($this->dataGet($attributes, 'valuations', []));

        parent::__construct($attributes);
    }

    public function vehicle(): TrendedValuationVehicleRequestBuilder
    {
        return $this->vehicle;
    }

    public function features(): VehicleFeatureInfoBuilder
    {
        return $this->features;
    }

    public function valuations(): TrendedValuationValuationsRequestBuilder
    {
        return $this->valuations;
    }

    public function setCondition(string $condition): TrendedValuationRequestBuilder
    {
        $conditions = new ValuationConditionTypes();

        if (!$conditions->contains($condition)) {
            throw new \Exception(
                sprintf(
                    'You tried to set invalid condition. [%s]',
                    $condition
                )
            );
        }

        $this->condition = $condition;

        return $this;
    }

    public function getCondition(): ?float
    {
        return $this->condition;
    }

    /**
     * @throws ValidationException
     */
    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicle' => $this->vehicle->toArray(),
            'features'   => $this->features->toArray(),
            'condition'  => $this->condition,
            'valuations' => $this->valuations->toArray(),
        ]);
    }
}
