<?php

namespace Olsgreen\AutoTrader\Api;

class Taxonomy extends AbstractApi
{
    /**
     * Retrieve available vehicle types.
     *
     * @param string $advertiserId
     *
     * @return array
     */
    public function types(string $advertiserId): array
    {
        return $this->_get('/service/stock-management/taxonomy/vehicleTypes', [
            'advertiserId' => $advertiserId,
        ]);
    }

    /**
     * Retrieve a vehicles types available makes.
     *
     * @param string $advertiserId
     * @param string $vehicleType
     *
     * @return array
     */
    public function makes(string $advertiserId, string $vehicleType): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/makes',
            ['vehicleType' => $vehicleType, 'advertiserId' => $advertiserId]
        );
    }

    /**
     * Retrieve a makes available models.
     *
     * @param string $advertiserId
     * @param string $makeId
     *
     * @return array
     */
    public function models(string $advertiserId, string $makeId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/models',
            ['makeId' => $makeId, 'advertiserId' => $advertiserId]
        );
    }

    /**
     * Retrieve a models available generations.
     *
     * @param string $advertiserId
     * @param string $modelId
     *
     * @return array
     */
    public function generations(string $advertiserId, string $modelId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/generations',
            ['modelId' => $modelId, 'advertiserId' => $advertiserId]
        );
    }

    /**
     * Retrieve a generations available derivatives.
     *
     * @param string $advertiserId
     * @param string $generationId
     *
     * @return array
     */
    public function derivatives(string $advertiserId, string $generationId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives',
            ['generationId' => $generationId, 'advertiserId' => $advertiserId]
        );
    }

    /**
     * Retrieve the technical data for a derivativeId.
     *
     * @param string $advertiserId
     * @param string $derivativeId
     *
     * @return array
     */
    public function technicalData(string $advertiserId, string $derivativeId): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/derivatives/'.$derivativeId,
            [
                'advertiserId' => $advertiserId,
            ]
        );
    }

    /**
     * Retrieve the features for a derivativeId.
     *
     * @param string $advertiserId
     * @param string $derivativeId
     * @param string $effectiveDate
     *
     * @return array
     */
    public function features(string $advertiserId, string $derivativeId, string $effectiveDate): array
    {
        return $this->_get(
            '/service/stock-management/taxonomy/features',
            ['derivativeId' => $derivativeId, 'effectiveDate' => $effectiveDate, 'advertiserId' => $advertiserId]
        );
    }

    /**
     * Retrieve manufacturer pricing data for a derivativeId.
     *
     * @param string      $advertiserId
     * @param string      $derivativeId
     * @param string|null $effectiveDate
     *
     * @return array
     */
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
