<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\ValuationConditionTypes;

class ValuationRequestBuilder extends AbstractBuilder
{
    protected $derivativeId;

    protected $firstRegistrationDate;

    protected $odometerReadingMiles;

    protected $features;

    protected $condition;

    public function __construct(array $attributes = [])
    {
        $this->features = new VehicleFeatureInfoBuilder($this->dataGet($attributes, 'features', []));

        parent::__construct($attributes);
    }

    public function features(): VehicleFeatureInfoBuilder
    {
        return $this->features;
    }

    public function setCondition(string $condition): ValuationRequestBuilder
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

    public function setDerivativeId(string $id): ValuationRequestBuilder
    {
        $this->derivativeId = $id;

        return $this;
    }

    public function getDerivativeId(): ?string
    {
        return $this->derivativeId;
    }

    public function setFirstRegistrationDate($date): ValuationRequestBuilder
    {
        if (!($date instanceof \DateTime)) {
            $date = new \DateTime($date);
        }

        $this->firstRegistrationDate = $date;

        return $this;
    }

    public function getFirstRegistrationDate(): ?\DateTime
    {
        return $this->firstRegistrationDate;
    }

    /**
     * Get the mileage.
     *
     * @return string|null
     */
    public function getOdometerReadingMiles(): ?string
    {
        return $this->odometerReadingMiles;
    }

    /**
     * Set the mileage.
     *
     * @param $miles
     *
     * @return $this
     */
    public function setOdometerReadingMiles($miles): ValuationRequestBuilder
    {
        $this->odometerReadingMiles = $miles;

        return $this;
    }

    public function validate(): bool
    {
        parent::validate();

        if (empty($this->odometerReadingMiles)) {
            throw new ValidationException(
                'odometerReadingMiles must not be empty.'
            );
        }

        if (empty($this->firstRegistrationDate)) {
            throw new ValidationException(
                'firstRegistrationDate must not be empty.'
            );
        }

        if (empty($this->firstRegistrationDate)) {
            throw new ValidationException(
                'firstRegistrationDate must not be empty.'
            );
        }

        return true;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicle' => [
                'derivativeId'          => $this->derivativeId,
                'firstRegistrationDate' => $this->firstRegistrationDate->format('Y-m-d'),
                'odometerReadingMiles'  => intval($this->odometerReadingMiles),
            ],
            'features'  => $this->features->toArray(),
            'condition' => $this->condition,
        ]);
    }
}
