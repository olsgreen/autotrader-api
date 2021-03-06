<?php


namespace Olsgreen\AutoTrader\Api\Builders;


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

    protected $vatExcluded;

    protected $priceOnApplication;

    protected $price;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->price = new StockItemPriceInfoBuilder(
            'Price',
            $this->dataGet($attributes, 'price', [])
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
    }

    public function setVatExcluded(bool $state): StockItemRetailAdvertsInfoBuilder
    {
        $this->vatExcluded = $state;

        return $this;
    }

    public function getVatExcluded(): bool
    {
        return $this->vatExcluded;
    }

    public function setPriceOnApplication(bool $state): StockItemRetailAdvertsInfoBuilder
    {
        $this->priceOnApplication = $state;

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

    function autotraderAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->autotraderAdvert;
    }

    function advertiserAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->advertiserAdvert;
    }

    function locatorAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->locatorAdvert;
    }

    function exportAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->exportAdvert;
    }

    function profileAdvert(): StockItemAdvertInfoBuilder
    {
        return $this->profileAdvert;
    }

    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'price' => $this->price->toArray(),
            'vatExcluded' => $this->vatExcluded,
            'priceOnApplication' => $this->priceOnApplication,
            'attentionGrabber' => $this->attentionGrabber,
            'description' => $this->description,
            'description2' => $this->description2,
            'autotraderAdvert' => $this->autotraderAdvert->toArray(),
            'advertiserAdvert' => $this->advertiserAdvert->toArray(),
            'locatorAdvert' => $this->locatorAdvert->toArray(),
            'exportAdvert' => $this->exportAdvert->toArray(),
            'profileAdvert' => $this->profileAdvert->toArray(),
        ]);
    }

}