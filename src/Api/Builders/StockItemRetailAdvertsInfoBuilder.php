<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\VatSchemes;
use Olsgreen\AutoTrader\Api\Enums\VatStatuses;

class StockItemRetailAdvertsInfoBuilder extends AbstractBuilder
{
    protected $attentionGrabber;

    protected $description;

    protected $description2;

    protected $autotraderAdvert;

    protected $advertiserAdvert;

    protected $locatorAdvert;

    protected $exportAdvert;

    protected $profileAdvert;

    protected $vatStatus;

    protected $priceOnApplication;

    protected $suppliedPrice;

    protected $displayOptions;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->suppliedPrice = new StockItemPriceInfoBuilder(
            'Supplied Price',
            $this->dataGet($attributes, 'suppliedPrice', [])
        );

        $this->autotraderAdvert = new StockItemAdvertInfoBuilder(
            'AutoTrader Advert',
            $this->dataGet($attributes, 'autotraderAdvert', [])
        );

        $this->advertiserAdvert = new StockItemAdvertInfoBuilder(
            'Advertiser Advert',
            $this->dataGet($attributes, 'advertiserAdvert', [])
        );

        $this->locatorAdvert = new StockItemAdvertInfoBuilder(
            'Locator Advert',
            $this->dataGet($attributes, 'locatorAdvert', [])
        );

        $this->exportAdvert = new StockItemAdvertInfoBuilder(
            'Export Advert',
            $this->dataGet($attributes, 'exportAdvert', [])
        );

        $this->profileAdvert = new StockItemAdvertInfoBuilder(
            'Profile Advert',
            $this->dataGet($attributes, 'profileAdvert', [])
        );

        $this->displayOptions = new StockItemRetailAdvertsDisplayOptionsBuilder(
            $this->dataGet($attributes, 'displayOptions', [])
        );
    }

    public function setVatStatus($status): StockItemRetailAdvertsInfoBuilder
    {
        $statuses = new VatStatuses();

        if (!$statuses->contains($status)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid VAT status.', $status)
            );
        }

        $this->vatStatus = $status;

        return $this;
    }

    public function getVatStatus(): string
    {
        return $this->vatStatus;
    }

    public function setPriceOnApplication($state): StockItemRetailAdvertsInfoBuilder
    {
        $this->priceOnApplication = boolval($state);

        return $this;
    }

    public function getPriceOnApplication(): bool
    {
        return $this->priceOnApplication;
    }

    public function setAttentionGrabber($text): StockItemRetailAdvertsInfoBuilder
    {
        $this->attentionGrabber = $text;

        return $this;
    }

    public function getAttentionGrabber(): string
    {
        return $this->attentionGrabber;
    }

    public function setDescription($text): StockItemRetailAdvertsInfoBuilder
    {
        $this->description = $text;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription2($text): StockItemRetailAdvertsInfoBuilder
    {
        $this->description2 = $text;

        return $this;
    }

    public function getDescription2(): string
    {
        return $this->description2;
    }

    public function autotraderAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->autotraderAdvert;
    }

    public function advertiserAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->advertiserAdvert;
    }

    public function locatorAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->locatorAdvert;
    }

    public function exportAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->exportAdvert;
    }

    public function profileAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->profileAdvert;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'suppliedPrice'      => $this->suppliedPrice->toArray(),
            'vatStatus'          => $this->vatStatus,
            'priceOnApplication' => $this->priceOnApplication,
            'attentionGrabber'   => $this->attentionGrabber,
            'description'        => $this->description,
            'description2'       => $this->description2,
            'autotraderAdvert'   => $this->autotraderAdvert->toArray(),
            'advertiserAdvert'   => $this->advertiserAdvert->toArray(),
            'locatorAdvert'      => $this->locatorAdvert->toArray(),
            'exportAdvert'       => $this->exportAdvert->toArray(),
            'profileAdvert'      => $this->profileAdvert->toArray(),
            'displayOptions'     => $this->displayOptions->toArray(),
        ]);
    }
}
