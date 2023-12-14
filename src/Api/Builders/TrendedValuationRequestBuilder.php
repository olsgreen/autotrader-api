<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\ValuationConditionTypes;

class TrendedValuationRequestBuilder extends AbstractBuilder
{
    protected $derivativeId;

    protected $firstRegistrationDate;

    protected $features;

    protected $condition;

    protected $valuations;

    public function __construct(array $attributes = [])
    {
        $this->features = new VehicleFeatureInfoBuilder($this->dataGet($attributes, 'features', []));

        $this->valuations = new TrendedValuationValuationsRequestBuilder($this->dataGet($attributes, 'valuations', []));

        parent::__construct($attributes);
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

    public function setDerivativeId(string $id): TrendedValuationRequestBuilder
    {
        $this->derivativeId = $id;

        return $this;
    }

    public function getDerivativeId(): ?string
    {
        return $this->derivativeId;
    }

    public function setFirstRegistrationDate($date): TrendedValuationRequestBuilder
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

    public function validate(): bool
    {
        parent::validate();

        if (empty($this->derivativeId)) {
            throw new ValidationException(
                'derivativeId must not be empty.'
            );
        }

        if (empty($this->firstRegistrationDate)) {
            throw new ValidationException(
                'firstRegistrationDate must not be empty.'
            );
        }

        return true;
    }

    /**
     * @throws ValidationException
     */
    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicle' => [
                'derivativeId'          => $this->derivativeId,
                'firstRegistrationDate' => $this->firstRegistrationDate->format('Y-m-d'),
            ],
            'features'   => $this->features->toArray(),
            'condition'  => $this->condition,
            'valuations' => $this->valuations->toArray(),
        ]);
    }
}
