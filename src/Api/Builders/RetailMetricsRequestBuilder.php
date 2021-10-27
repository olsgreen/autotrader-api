<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class RetailMetricsRequestBuilder extends AbstractBuilder
{
    protected $vrm;

    protected $mileage;

    protected $features;

    public function __construct(array $attributes = [])
    {
        $this->features = new VehicleFeatureInfoBuilder($this->dataGet($attributes, 'features', []));

        parent::__construct($attributes);
    }

    public function getVrm(): string
    {
        return $this->vrm;
    }

    public function setVrm(string $vrm): self
    {
        $this->vrm = $vrm;

        return $this;
    }

    public function getMileage(): string
    {
        return $this->mileage;
    }

    public function setMileage($mileage): self
    {
        $this->mileage = (string) $mileage;

        return $this;
    }

    public function validate(): bool
    {
        parent::validate();

        if (empty($this->vrm)) {
            throw new ValidationException(
                'vrm must not be empty.'
            );
        }

        if (empty($this->mileage)) {
            throw new ValidationException(
                'mileage must not be empty.'
            );
        }

        return true;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vrm'      => $this->vrm,
            'mileage'  => $this->mileage,
            'features' => $this->features->toArray(),
        ]);
    }
}
