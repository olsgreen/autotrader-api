<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\TrendedValuationFrequencyTypes;
use Olsgreen\AutoTrader\Api\Enums\TrendedValuationMarketTypes;

class TrendedValuationValuationsRequestBuilder extends AbstractBuilder
{
    protected $markets;

    protected $frequency;

    protected $start;

    protected $end;

    public function __construct(array $attributes = [])
    {
        $this->start = new TrendedValuationDateRequestBuilder($this->dataGet($attributes, 'start', []));
        $this->end = new TrendedValuationDateRequestBuilder($this->dataGet($attributes, 'end', []));

        parent::__construct($attributes);
    }

    public function start(): TrendedValuationDateRequestBuilder
    {
        return $this->start;
    }

    public function end(): TrendedValuationDateRequestBuilder
    {
        return $this->end;
    }

    public function setMarkets(array $markets): TrendedValuationValuationsRequestBuilder
    {
        $marketTypes = new TrendedValuationMarketTypes();

        foreach ($markets as $market) {
            if (!$marketTypes->contains($market)) {
                throw new \Exception(
                    sprintf(
                        'You tried to set invalid an market type. [%s]',
                        $market
                    )
                );
            }
        }

        $this->markets = array_values($markets);

        return $this;
    }

    public function getMarkets(): ?array
    {
        return $this->markets;
    }

    public function setFrequency(string $frequency): TrendedValuationValuationsRequestBuilder
    {
        $frequencies = new TrendedValuationFrequencyTypes();

        if (!$frequencies->contains($frequency)) {
            throw new \Exception(
                sprintf(
                    'You tried to set invalid frequency. [%s]',
                    $frequency
                )
            );
        }

        $this->frequency = $frequency;

        return $this;
    }

    public function getFrequency(): ?array
    {
        return $this->frequency;
    }

    public function validate(): bool
    {
        parent::validate();

        if (empty($this->markets)) {
            throw new ValidationException(
                'markets must not be empty.'
            );
        }

        if (empty($this->frequency)) {
            throw new ValidationException(
                'frequency must not be empty.'
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
            'markets'    => $this->markets,
            'frequency'  => $this->frequency,
            'start'      => $this->start->toArray(),
            'end'        => $this->end->toArray(),
        ]);
    }
}
