<?php

namespace Olsgreen\AutoTrader\Api;

class Taxonomy extends AbstractApi
{
    public function types()
    {
        return $this->_get('/service/stock-management/taxonomy/vehicleTypes');
    }

    public function makes(string $vehicleType)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/makes',
            ['vehicleType' => $vehicleType]
        );
    }

    public function models(string $makeId)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/models',
            ['makeId' => $makeId]
        );
    }

    public function generations(string $modelId)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/generations',
            ['modelId' => $modelId]
        );
    }

    public function derivatives(string $generationId)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives',
            ['generationId' => $generationId]
        );
    }

    public function technicalData(string $derivativeId)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives/' . $derivativeId
        );
    }

    public function features(string $derivativeId, string $effectiveDate)
    {
        return $this->_get(
            '/service/stock-management/taxonomy/features',
            ['derivativeId' => $derivativeId, 'effectiveDate' => $effectiveDate]
        );
    }

    public function prices(string $derivativeId, string $effectiveDate = null)
    {
        $options = ['derivativeId' => $derivativeId];

        if ($effectiveDate) {
            $options['effectiveDate'] = $effectiveDate;
        }

        return $this->_get(
            '/service/stock-management/taxonomy/prices',
            $options
        );
    }
}
