<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class StockItemPriceInfoBuilder extends AbstractNameableBuilder
{
    protected $amountGBP;

    public function setAmountGbp($amount): StockItemPriceInfoBuilder
    {
        $this->amountGBP = (float) $amount;

        return $this;
    }

    public function getAmountGbp(): float
    {
        return $this->amountGBP;
    }

    public function toArray(): array
    {
        return $this->filterPrepareOutput([
            'amountGBP' => $this->amountGBP
        ]);
    }
}