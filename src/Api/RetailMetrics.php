<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\RetailMetricsRequestBuilder;

class RetailMetrics extends AbstractApi
{
    /**
     * $request = MetricRequestBuilder::create();.
     *
     * $request
     *  ->setVrm('ABC123')
     *  ->setMileage(8000);
     *
     * $valuation = $api->vehicleMetrics()->lookup($request)
     */
    public function lookup(string $advertiserId, RetailMetricsRequestBuilder $builder)
    {
        return $this->_post(
            '/service/retail-metrics/4.1/vehicle',
            ['advertiserId' => $advertiserId],
            $builder->toJson()
        );
    }
}