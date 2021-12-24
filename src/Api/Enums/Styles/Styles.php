<?php

namespace Olsgreen\AutoTrader\Api\Enums\Styles;

use Marque\Support\Csv;

class Styles
{
    protected $data;

    public function __construct()
    {
        $this->loadData();
    }

    protected function loadData(): self
    {
        $styles = [];

        $rows = new Csv(__DIR__ . '/data.csv');

        foreach ($rows as $row) {
            $styles[] = $row;
        }

        $this->data = $styles;

        return $this;
    }

    public function getStylesFor(string $vehicleType): array
    {
        $data = array_filter($this->data, function($row) use ($vehicleType) {
            return strtolower($row['Vehicle Type']) === strtolower($vehicleType);
        });

        $data = array_map(function($row) {
           return $row['Style'];
        }, $data);

        return array_values(array_unique($data));
    }

    public function getSubStylesFor(string $vehicleType, string $style): array
    {
        $data = array_filter($this->data, function($row) use ($vehicleType, $style) {
            return strtolower($row['Vehicle Type']) === strtolower($vehicleType)
                && strtolower($row['Style']) === strtolower($style);
        });

        return array_values(array_map(function($row) {
           return $row['Sub Style'];
        }, $data));
    }
}