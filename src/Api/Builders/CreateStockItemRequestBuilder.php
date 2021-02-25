<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class CreateStockItemRequestBuilder extends AbstractBuilder
{
    protected $vehicleInfo;

    protected $stockItemMetaInfo;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->vehicleInfo = new VehicleInfoBuilder(
            array_key_exists('vehicle', $attributes) ? $attributes['vehicle'] : []
        );

        $this->stockItemMetaInfo = new StockItemMetaInfoBuilder(
            array_key_exists('meta', $attributes) ? $attributes['meta'] : []
        );
    }

    public function getFriendlyName(): string
    {
        return 'Stock Item';
    }

    public function vehicle(): VehicleInfoBuilder
    {
        return $this->vehicleInfo;
    }

    public function meta(): StockItemMetaInfoBuilder
    {
        return $this->stockItemMetaInfo;
    }

    public function validate(): bool
    {
        $this->vehicleInfo->validate();

        $this->stockItemMetaInfo->validate();

        return true;
    }

    public function prepare(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vehicle' => $this->vehicle()->prepare(),
            'meta' => $this->meta()->prepare(),
        ]);
    }
}