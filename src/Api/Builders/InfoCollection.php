<?php

namespace Olsgreen\AutoTrader\Api\Builders;

class InfoCollection extends AbstractBuilder implements BuilderInterface
{
    protected $minimumItems;

    protected $items = [];

    protected $infoType;

    protected $label;

    public function __construct(string $label, string $infoType, int $minimumItems = 0)
    {
        $this->label = $label;

        $this->infoType = $infoType;

        $this->minimumItems = $minimumItems;
    }

    public function add(BuilderInterface $builder)
    {
        if (!($builder instanceof $this->infoType)) {
            throw new \Exception(
                sprintf(
                    'This collection can only accept builders of the \'%s\' type, you passed a \'%s\'.',
                    $this->infoType,
                    get_class($builder)
                )
            );
        }

        $this->items[] = $builder;

        return $this;
    }

    public function remove(BuilderInterface $builder)
    {
        $this->items = array_filter($this->items, function ($item) use ($builder) {
            return $builder !== $item;
        });

        return $this;
    }

    public function contains(Builder $builder)
    {
        return in_array($builder, $this->items);
    }

    public function validate()
    {
        $errors = [];

        if (!(count($this->items) >= $this->minimumItems)) {
            $errors['minimumItems'] = 'There must be at least %d items in the collection.';
        }

        return empty($errors) ? true : $errors;
    }

    public function make(): array
    {
        $this->validateOrThrow();

        foreach ($this->items as $item) {
            $item->validateOrThrow();
        }

        return array_map(function ($item) {
            return $item->make();
        }, $this->items);
    }

    protected function validateOrThrow()
    {
        if ($this->validate() !== true) {
            throw new \Exception(
                sprintf(
                    '%s: Must have at least one item.',
                    $this->label
                )
            );
        }
    }
}
