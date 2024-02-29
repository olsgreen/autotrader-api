<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\ReservationStatuses;
use Olsgreen\AutoTrader\Api\Enums\VatSchemes;

class StockItemAdvertsInfoBuilder extends AbstractBuilder
{
    protected $allowEmpty = ['reservationStatus'];

    protected $forecourtPrice;

    protected $retailAdverts;

    protected $vatScheme;

    protected $reservationStatus;

    protected $dueDate;

    protected $stockInDate;

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

    public function setVatScheme($scheme): self
    {
        $schemes = new VatSchemes();

        if (!$schemes->contains($scheme)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid VAT scheme.', $scheme)
            );
        }

        $this->vatScheme = $scheme;

        return $this;
    }

    public function getVatScheme(): string
    {
        return $this->vatScheme;
    }

    public function setStockInDate($date): self
    {
        if (isset($date) && !($date instanceof \DateTime)) {
            $date = new \DateTime($date);
        }

        $this->stockInDate = $date;

        return $this;
    }

    public function getStockInDate(): ?\DateTime
    {
        return $this->stockInDate;
    }

    public function setDueDate($date): self
    {
        if (isset($date) && !($date instanceof \DateTime)) {
            $date = new \DateTime($date);
        }

        $this->dueDate = $date;

        return $this;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'vatScheme'          => $this->vatScheme,
            'reservationStatus' => $this->reservationStatus,
            'forecourtPrice'    => $this->forecourtPrice->toArray(),
            'retailAdverts'     => $this->retailAdverts->toArray(),
            'stockInDate'       => $this->stockInDate ? $this->stockInDate->format('Y-m-d') : null,
            'dueDate'           => $this->dueDate ? $this->dueDate->format('Y-m-d') : null,
        ]);
    }
}
