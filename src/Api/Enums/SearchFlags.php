<?php


namespace Olsgreen\AutoTrader\Api\Enums;


class SearchFlags extends SharedFlags
{
    /**
     * Public Search
     * Perform a global search on Auto Trader Adverts.
     */
    const PUBLIC_SEARCH = 'public';

    /**
     * Response Metrics
     * Advert response metrics.
     */
    const RESPONSE_METRICS = 'responseMetrics';
}