<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class MetricRequestBuilder extends ValuationRequestBuilder
{
    protected $location;

    public function setLocation(array $latLng): self
    {
        if (empty($latLng['latitude']) || empty($latLng['longitude'])) {
            throw new \Exception('Location array missing either latitude or longitude');
        }

        $this->location = [
            'latitude' => $latLng['latitude'],
            'longitude' => $latLng['longitude']
        ];

        return $this;
    }

    public function getLocation():? array
    {
        return $this->location;
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        return $this->filterPrepareOutput(
            array_merge(
                $array,
                ["location" => $this->location]
            )
        );
    }
}
