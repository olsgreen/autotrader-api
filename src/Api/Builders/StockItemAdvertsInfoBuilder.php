<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\ReservationStatuses;

class StockItemAdvertsInfoBuilder extends AbstractBuilder
{
    protected $allowEmpty = ['reservationStatus'];

    protected $forecourtPrice;

    protected $retailAdverts;

    protected $reservationStatus;

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

    public function getReservationStatus(): ?string
    {
        return $this->reservationStatus;
    }

    public function setReservationStatus($status): self
    {
        $statusList = new ReservationStatuses();

        if (!$statusList->contains($status)) {
            throw new \Exception(
                sprintf(
                    'You tried to set invalid status. [%s]',
                    $status
                )
            );
        }

        $this->reservationStatus = $status;

        return $this;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'reservationStatus' => $this->reservationStatus,
            'forecourtPrice'    => $this->forecourtPrice->toArray(),
            'retailAdverts'     => $this->retailAdverts->toArray(),
        ]);
    }
}
