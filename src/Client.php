<?php


namespace Olsgreen\AutoTrader;


use Closure;
use Olsgreen\AutoTrader\Api\Authentication;
use Olsgreen\AutoTrader\Api\Adverts;
use Olsgreen\AutoTrader\Api\Stock;
use Olsgreen\AutoTrader\Api\Taxonomy;
use Olsgreen\AutoTrader\Api\Valuations;
use Olsgreen\AutoTrader\Api\VehicleMetrics;
use Olsgreen\AutoTrader\Api\Vehicles;
use Olsgreen\AutoTrader\Http\ClientInterface;
use Olsgreen\AutoTrader\Http\GuzzleClient;

class Client extends AbstractClient
{
    use ManagesHttpAccessTokens;

    /**
     * Set this clients options from array.
     *
     * @param array $options
     */
    protected function configureFromArray(array $options): AbstractClient
    {
        if (isset($options['access_token'])) {
            $this->setAccessToken($options['access_token']);
        }

        $baseUri = 'https://api.autotrader.co.uk';

        if (isset($options['sandbox'])) {
            $baseUri = 'https://api-sandbox.autotrader.co.uk';
        }

        $this->http->setBaseUri($baseUri);

        return $this;
    }

    public function adverts(): Adverts
    {
        return new Adverts($this);
    }

    public function authentication(): Authentication
    {
        return new Authentication($this);
    }

    public function stock(): Stock
    {
        return new Stock($this);
    }

    public function taxonomy(): Taxonomy
    {
        return new Taxonomy($this);
    }

    public function valuations(): Valuations
    {
        return new Valuations($this);
    }

    public function vehicles(): Vehicles
    {
        return new Vehicles($this);
    }

    public function vehicleMetrics(): VehicleMetrics
    {
        return new VehicleMetrics($this);
    }
}