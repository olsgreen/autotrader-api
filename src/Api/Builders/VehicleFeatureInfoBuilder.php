<?php


namespace Olsgreen\AutoTrader\Api\Builders;


use Olsgreen\AutoTrader\Api\Enums\VehicleFeatureTypes;

class VehicleFeatureInfoBuilder extends AbstractBuilder
{
    protected $features = [];

    public function setAttributes(array $attributes = []): AbstractBuilder
    {
        foreach ($attributes as $feature) {
            $this->add($feature['name'], $feature['type']);
        }

        return $this;
    }

    public function add(string $name, string $type): VehicleFeatureInfoBuilder
    {
        $types = new VehicleFeatureTypes();

        if (!$types->contains($type)) {
            throw new \Exception(
                sprintf('\'%s\' is an invalid feature type.', $type)
            );
        }

        $this->features[] = ['name' => $name, 'type' => $type];

        return $this;
    }

    public function remove(string $name): VehicleFeatureInfoBuilder
    {
        $this->features = array_filter($this->features, function ($item) use ($name) {
            return $item['name'] !== $name;
        });

        return $this;
    }

    public function all(): array
    {
        return $this->features;
    }

    public function prepare():array
    {
        return $this->all();
    }
}