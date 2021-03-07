<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class StockItemImageInfoBuilder extends AbstractBuilder
{
    protected $images = [];

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $imageId) {
            if (is_string($imageId)) {
                $this->add($imageId);
            } elseif (is_array($imageId)) {
                $this->add($imageId['imageId']);
            } else {
                throw new \InvalidArgumentException('Invalid imageId');
            }
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
