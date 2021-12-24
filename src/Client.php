<?php

namespace Olsgreen\AutoTrader;

use Olsgreen\AutoTrader\Api\Authentication;
use Olsgreen\AutoTrader\Api\Leads;
use Olsgreen\AutoTrader\Api\Search;
use Olsgreen\AutoTrader\Api\Stock;
use Olsgreen\AutoTrader\Api\Taxonomy;
use Olsgreen\AutoTrader\Api\Valuations;
use Olsgreen\AutoTrader\Api\VehicleMetrics;
use Olsgreen\AutoTrader\Api\Vehicles;

class Client extends AbstractClient
{
    use ManagesHttpAccessTokens;

    /**
     * Set client options from array.
     *
     * @param array $options
     *
     * @return AbstractClient
     */
    protected function configureFromArray(array $options): AbstractClient
    {
        if (isset($options['access_token'])) {
            $this->setAccessToken($options['access_token']);
        }

        $baseUri = 'https://api.autotrader.co.uk';

        if (isset($options['sandbox']) && $options['sandbox'] === true) {
            $baseUri = 'https://api-sandbox.autotrader.co.uk';
        }

        $this->http->setBaseUri($baseUri);

        return $this;
    }

    /**
     * Access Token Management.
     *
     * @see https://developers.autotrader.co.uk/api#authentication
     *
     * @return Authentication
     */
    public function authentication(): Authentication
    {
        return new Authentication($this);
    }

    /**
     * Stock Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#stock-endpoint
     *
     * @return Stock
     */
    public function stock(): Stock
    {
        return new Stock($this);
    }

    /**
     * Taxonomy Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#taxonomy-endpoint
     *
     * @return Taxonomy
     */
    public function taxonomy(): Taxonomy
    {
        return new Taxonomy($this);
    }

    /**
     * Valuations Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#valuations-endpoint
     *
     * @return Valuations
     */
    public function valuations(): Valuations
    {
        return new Valuations($this);
    }

    /**
     * Vehicles Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#vehicles-endpoint
     *
     * @return Vehicles
     */
    public function vehicles(): Vehicles
    {
        return new Vehicles($this);
    }

    /**
     * Vehicle Metrics Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#vehicle-metrics-endpoint
     *
     * @return VehicleMetrics
     */
    public function vehicleMetrics(): VehicleMetrics
    {
        return new VehicleMetrics($this);
    }

    /**
     * Search Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#search-endpoint
     *
     * @return Search
     */
    public function adverts(): Search
    {
        return new Search($this);
    }

    /**
     * Leads Endpoint.
     *
     * @see https://developers.autotrader.co.uk/api#leads-api
     *
     * @return Leads
     */
    public function leads(): Leads
    {
        return new Leads($this);
    }
}
