<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\ValuationRequestBuilder;

class Valuations extends AbstractApi
{
    /**
     * $request = ValuationRequestBuilder::create();.
     *
     * $request->vehicle()
     *  ->setDerivativeId('ABC123')
     *  ->setFirstRegisteredDate('2020-11-01')
     *  ->setOdometerReadingMiles(8000);
     *
     * $valuation = $api->valuations()->retrieve($request)
     */
    public function value(ValuationRequestBuilder $builder)
    {
    }
}
