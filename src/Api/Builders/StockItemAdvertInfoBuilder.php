<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\AdvertStatus;

class StockItemAdvertInfoBuilder extends AbstractNameableBuilder
{
    protected $status;

    public function setStatus(string $status): StockItemAdvertInfoBuilder
    {
        $statuses = new AdvertStatus();

        if (!$statuses->contains($status)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid advert status.', $status)
            );
        }

        $this->status = $status;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return $this->filterPrepareOutput([
            'status' => $this->status,
        ]);
    }
}
