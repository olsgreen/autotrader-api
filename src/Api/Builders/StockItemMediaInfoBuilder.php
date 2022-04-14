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

    public function setVideoUrl($url): StockItemMediaInfoBuilder
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

    public function toArray(): array
    {
        return $this->filterPrepareOutput([
            'video'    => ['href' => $this->videoUrl],
            'images'   => $this->imageInfoBuilder->all(),
        ]);
    }
}
