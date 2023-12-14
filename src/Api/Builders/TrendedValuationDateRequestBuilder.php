<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class TrendedValuationDateRequestBuilder extends AbstractBuilder
{
    protected $date;

    protected $odometerReadingMiles;

    public function setDate(string $date): TrendedValuationDateRequestBuilder
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);

        if (!$date) {
            throw new \InvalidArgumentException(
                sprintf('"%s" must be a valid date in Y-m-d format.', $date)
            );
        }

        $this->date = $date;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setOdometerReadingMiles(string $miles): TrendedValuationDateRequestBuilder
    {
        $this->odometerReadingMiles = $miles;

        return $this;
    }

    public function getOdometerReadingMiles(): ?string
    {
        return $this->odometerReadingMiles;
    }

    public function validate(): bool
    {
        parent::validate();

        if (empty($this->odometerReadingMiles)) {
            throw new ValidationException(
                'odometerReadingMiles must not be empty.'
            );
        }

        if (empty($this->date)) {
            throw new ValidationException(
                'date must not be empty.'
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
            'odometerReading' => $this->odometerReadingMiles,
            'date'            => $this->date,
        ]);
    }
}
