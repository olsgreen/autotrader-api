<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class UpdateStockItemRequestBuilder extends CreateStockItemRequestBuilder
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->vehicle()->setRequiredAttributes([]);

        $this->meta()->setRequiredAttributes([]);
    }
}