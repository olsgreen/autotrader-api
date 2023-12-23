<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class TrendedValuationVehicleRequestBuilder extends AbstractBuilder
{
    protected $derivativeId;

    protected $firstRegistrationDate;

    public function setDerivativeId(string $id): TrendedValuationVehicleRequestBuilder
    {
        $this->derivativeId = $id;

        return $this;
    }

    public function getDerivativeId(): ?string
    {
        return $this->derivativeId;
    }

    public function setFirstRegistrationDate($date): TrendedValuationVehicleRequestBuilder
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

    public function toArray(): array
    {
        return [
            'derivativeId'          => $this->derivativeId,
            'firstRegistrationDate' => $this->firstRegistrationDate->format('Y-m-d'),
        ];
    }
}