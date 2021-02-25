<?php


namespace Olsgreen\AutoTrader\Api\Builders;


class StockItemImageInfoBuilder extends AbstractBuilder
{
    protected $images = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        foreach ($attributes as $imageId) {
            $this->add($imageId);
        }
    }

    public function add(string $id): StockItemImageInfoBuilder
    {
        $this->images[] = ['imageId' => $id];

        return $this;
    }

    public function remove(string $id): StockItemImageInfoBuilder
    {
        $this->images = array_filter($this->images, function ($item) use ($id) {
            return $id === $item['imageId'];
        });

        return $this;
    }

    public function clear(): StockItemImageInfoBuilder
    {
        $this->images = [];

        return $this;
    }

    public function all(): array
    {
        return $this->images;
    }

    public function toArray(): array
    {
        return $this->all();
    }
}