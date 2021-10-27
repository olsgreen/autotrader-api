<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\MetricRequestBuilder;

class VehicleMetrics extends AbstractApi
{
    /**
     * Lookup a vehicles metrics.
     *
     * @param string               $advertiserId
     * @param MetricRequestBuilder $builder
     *
     * @return array
     *
     * @example
     * $request = MetricRequestBuilder::create();
     *
     * $request->vehicle()
     *  ->setDerivativeId('ABC123')
     *  ->setFirstRegisteredDate('2020-11-01')
     *  ->setOdometerReadingMiles(8000);
     *
     * $valuation = $api->vehicleMetrics()->lookup(12345, $request)
     */
    public function lookup(string $advertiserId, MetricRequestBuilder $builder)
    {
        return $this->_post(
            '/service/stock-management/vehicleMetrics',
            ['advertiserId' => $advertiserId],
            $builder->toJson()
        );
    }
}
