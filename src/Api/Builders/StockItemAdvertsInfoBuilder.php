<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class StockItemAdvertsInfoBuilder extends AbstractBuilder
{
    protected $forecourtPrice;

    protected $retailAdverts;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->forecourtPrice = new StockItemPriceInfoBuilder(
            'Forecourt Price',
            $this->dataGet($attributes, 'forecourtPrice', [])
        );

        $this->retailAdverts = new StockItemRetailAdvertsInfoBuilder(
            $this->dataGet($attributes, 'retailAdverts', [])
        );
    }

    public function forecourtPrice(): StockItemPriceInfoBuilder
    {
        return $this->forecourtPrice;
    }

    public function retailAdverts(): StockItemRetailAdvertsInfoBuilder
    {
        return $this->retailAdverts;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'forecourtPrice' => $this->forecourtPrice->toArray(),
            'retailAdverts'  => $this->retailAdverts->toArray(),
        ]);
    }
}
