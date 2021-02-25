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

    /*public function prepare(): array
    {
        return array_filter(parent::prepare(), function ($item) {
            return isset($item) && !(is_array($item) && empty($item));
        });
    }*/
}