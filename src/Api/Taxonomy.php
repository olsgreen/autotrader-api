<?php

namespace Olsgreen\AutoTrader\Api;

class Taxonomy extends AbstractApi
{
    public function types(string $advertiserId): array
    {
        return $this->_get('/service/stock-management/taxonomy/vehicleTypes', [
            'advertiserId' => $advertiserId
        ]);
    }

    public function makes(string $advertiserId, string $vehicleType): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/makes',
            ['vehicleType' => $vehicleType, 'advertiserId' => $advertiserId]
        );
    }

    public function models(string $advertiserId, string $makeId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/models',
            ['makeId' => $makeId, 'advertiserId' => $advertiserId]
        );
    }

    public function generations(string $advertiserId, string $modelId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/generations',
            ['modelId' => $modelId, 'advertiserId' => $advertiserId]
        );
    }

    public function derivatives(string $advertiserId, string $generationId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives',
            ['generationId' => $generationId, 'advertiserId' => $advertiserId]
        );
    }

    public function technicalData(string $advertiserId, string $derivativeId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives/' . $derivativeId, [
                    'advertiserId' => $advertiserId
            ]
        );
    }

    public function features(string $advertiserId, string $derivativeId, string $effectiveDate): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/features',
            ['derivativeId' => $derivativeId, 'effectiveDate' => $effectiveDate, 'advertiserId' => $advertiserId]
        );
    }

    public function prices(string $advertiserId, string $derivativeId, string $effectiveDate = null)
    {
        $options = ['derivativeId' => $derivativeId, 'advertiserId' => $advertiserId];

        if ($effectiveDate) {
            $options['effectiveDate'] = $effectiveDate;
        }

        return $this->_get(
            '/service/stock-management/taxonomy/prices',
            $options
        );
    }
}
