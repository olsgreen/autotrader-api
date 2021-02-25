<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class CreateStockItemRequestBuilder extends AbstractBuilder
{
    protected $vehicleInfo;

    protected $stockItemMetaInfo;

    protected $advertsInfo;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->vehicleInfo = new VehicleInfoBuilder($this->dataGet($attributes, 'vehicle', []));

        $this->advertsInfo = new StockItemAdvertsInfoBuilder($this->dataGet($attributes, 'adverts', []));

        $this->stockItemMetaInfo = new StockItemMetaInfoBuilder($this->dataGet($attributes, 'meta', []));
    }

    public function getFriendlyName(): string
    {
        return 'Stock Item';
    }

    public function vehicle(): VehicleInfoBuilder
    {
        return $this->vehicleInfo;
    }

    public function adverts(): StockItemAdvertsInfoBuilder
    {
        return $this->advertsInfo;
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
            'adverts' => $this->adverts()->prepare(),
            'meta' => $this->meta()->prepare(),
        ]);
    }
}