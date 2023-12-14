<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\TrendedValuationRequestBuilder;
use Olsgreen\AutoTrader\Api\Builders\ValuationRequestBuilder;

class Valuations extends AbstractApi
{
    /**
     * Retrieve a valuation.
     *
     * @param string                  $advertiserId
     * @param ValuationRequestBuilder $builder
     *
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

    /**
     * Retrieve a valuation.
     *
     * @param string                         $advertiserId
     * @param TrendedValuationRequestBuilder $builder
     *
     * @return array
     *
     * @example
     * $request = TrendedValuationRequestBuilder::create([
     * [
     *       'derivativeId' => '40a80ca0d16541789f2514ebadca3d66',
     *       'firstRegistrationDate' => '2022-11-10',
     *       'valuations' => [
     *           'markets' => ['retail'],
     *           'frequency' => 'month',
     *           'start' => ['date' => '2023-09-01', 'odometerReadingMiles' => 40000],
     *           'end' => ['date' => '2024-08-01', 'odometerReadingMiles' => 52000]
     *       ]
     *   ]
     * ]);
     *
     * $valuation = $api->valuations()->trends($request)
     */
    public function trends(string $advertiserId, TrendedValuationRequestBuilder $builder)
    {
        return $this->_post(
            '/service/stock-management/valuations/trends',
            ['advertiserId' => $advertiserId],
            $builder->toJson()
        );
    }
}
