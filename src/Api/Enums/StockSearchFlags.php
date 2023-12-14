<?php

namespace Olsgreen\AutoTrader\Api\Enums;

class StockSearchFlags extends SharedFlags
{
    /**
     * Response Metrics.
     *
     * Return advertising performance data for stock.
     */
    const RESPONSE_METRICS = 'responseMetrics';

    /**
     * Valuations.
     *
     * Return valuation data for stock.
     */
    const VALUATIONS = 'valuations';
}
