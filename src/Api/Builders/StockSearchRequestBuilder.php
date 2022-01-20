<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\LifecycleStates;
use Olsgreen\AutoTrader\Api\Enums\SearchFlags;
use Olsgreen\AutoTrader\Api\Enums\StockSearchFlags;

class StockSearchRequestBuilder extends AbstractBuilder
{
    use HasFlags;

    protected $searchId;

    protected $stockId;

    protected $pageSize;

    protected $page;

    protected $lifecycleState;

    protected $registration;

    protected $vin;

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): StockSearchRequestBuilder
    {
        $this->vin = $vin;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): StockSearchRequestBuilder
    {
        $this->registration = $registration;

        return $this;
    }

    public function getLifecycleState(): ?string
    {
        return $this->lifecycleState;
    }

    public function setLifecycleState(string $state): StockSearchRequestBuilder
    {
        $statesList = new LifecycleStates();

        if (!$statesList->contains($state)) {
            throw new \Exception(
                sprintf(
                    'You tried to set invalid state. [%s]',
                    $state
                )
            );
        }

        $this->lifecycleState = $state;

        return $this;
    }

    public function setSearchId(string $searchId): StockSearchRequestBuilder
    {
        $this->searchId = $searchId;

        return $this;
    }

    public function getSearchId(): ?string
    {
        return $this->searchId;
    }

    public function setStockId(string $stockId): StockSearchRequestBuilder
    {
        $this->stockId = $stockId;

        return $this;
    }

    public function getStockId(): ?string
    {
        return $this->stockId;
    }

    public function setPage($page): StockSearchRequestBuilder
    {
        $this->page = (int) $page;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPageSize($size): StockSearchRequestBuilder
    {
        $this->pageSize = $size;

        return $this;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    public function validate(): bool
    {
        $setKeys = array_filter(['searchId', 'stockId', 'registration', 'vin'], function ($key) {
            return !empty($this->$key);
        });

        if (count($setKeys) > 1) {
            throw new \InvalidArgumentException(
                'You must only specify a searchId, stockId, registration or VIN.'
            );
        }

        return parent::validate();
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'stockId'           => $this->stockId,
            'searchId'          => $this->searchId,
            'lifecycleState'    => $this->lifecycleState,
            'registration'      => $this->registration,
            'vin'               => $this->vin,
            'pageSize'          => $this->pageSize,
            'page'              => $this->page,
        ]);
    }
}
