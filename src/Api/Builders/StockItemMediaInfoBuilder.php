<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class StockItemMediaInfoBuilder extends AbstractBuilder
{
    protected $videoUrl;

    protected $imageInfoBuilder;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->imageInfoBuilder = new StockItemImageInfoBuilder($this->dataGet($attributes, 'images', []));
    }

    public function getFriendlyName(): string
    {
        return 'Media';
    }

    public function setVideoUrl(string $url): StockItemMediaInfoBuilder
    {
        $this->videoUrl = $url;

        return $this;
    }

    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    public function images(): StockItemImageInfoBuilder
    {
        return $this->imageInfoBuilder;
    }

    public function prepare(): array
    {
        return $this->filterPrepareOutput([
            'videoUrl' => $this->videoUrl,
            'images' => $this->imageInfoBuilder->all(),
        ]);
    }
}