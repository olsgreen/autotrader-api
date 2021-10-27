<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\ValuationRequestBuilder;

class Valuations extends AbstractApi
{

    /**
     * Retrieve a valuation.
     *
     * @param string $advertiserId
     * @param ValuationRequestBuilder $builder
     * @return array
     *
     * @example
     * $request = ValuationRequestBuilder::create();.
     *
     * $request->vehicle()
     *  ->setDerivativeId('ABC123')
     *  ->setFirstRegisteredDate('2020-11-01')
     *  ->setOdometerReadingMiles(8000);
     *
     * $valuation = $api->valuations()->retrieve($request)
     */
    public function value(string $advertiserId, ValuationRequestBuilder $builder)
    {
        return $this->_post(
            '/service/stock-management/valuations',
            ['advertiserId' => $advertiserId],
            $builder->toJson()
        );
    }
}
