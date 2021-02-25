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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

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

    public function getFriendlyName(): string
    {
        return 'Retail Adverts';
    }

    public function setAttentionGrabber(string $text): StockItemRetailAdvertsInfoBuilder
    {
        $this->attentionGrabber = $text;
    }

    public function getAttentionGrabber(): string
    {
        return $this->attentionGrabber;
    }

    public function setDescription(string $text): StockItemRetailAdvertsInfoBuilder
    {
        $this->description = $text;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription2(string $text): StockItemRetailAdvertsInfoBuilder
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

    public function prepare(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'attentionGrabber' => $this->attentionGrabber,
            'description' => $this->description,
            'description2' => $this->description2,
            'autotraderAdvert' => $this->autotraderAdvert->prepare(),
            'advertiserAdvert' => $this->advertiserAdvert->prepare(),
            'locatorAdvert' => $this->locatorAdvert->prepare(),
            'exportAdvert' => $this->exportAdvert->prepare(),
            'profileAdvert' => $this->profileAdvert->prepare(),
        ]);
    }

}