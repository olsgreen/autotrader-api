<?php


namespace Olsgreen\AutoTrader;


use Closure;
use Olsgreen\AutoTrader\Api\Authentication;
use Olsgreen\AutoTrader\Http\ClientInterface;
use Olsgreen\AutoTrader\Http\GuzzleClient;

class Client
{
    /**
     * HTTP Client Instance
     *
     * @var ClientInterface
     */
    protected $http;

    /**
     * Client constructor.
     *
     * @param array $options
     * @param ClientInterface|null $http
     */
    public function __construct(array $options = [], ClientInterface $http = null)
    {
        $this->http = $http ?? new GuzzleClient();

        $this->configureFromArray($options);
    }

    /**
     * Get the underlying HTTP client instance.
     *
     * @return ClientInterface
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * Set this clients options from array.
     *
     * @param array $options
     */
    protected function configureFromArray(array $options)
    {
        if (isset($options['access_token'])) {
            $this->setAccessToken($options['access_token']);
        }

        $baseUri = 'https://api.autotrader.co.uk';

        if (isset($options['sandbox'])) {
            $baseUri = 'https://api-sandbox.autotrader.co.uk';
        }

        $this->http->setBaseUri($baseUri);
    }

    /**
     * Set the access token.
     *
     * @param $token
     * @return $this
     */
    public function setAccessToken($token): Client
    {
        $this->http->setAccessToken($token);

        return $this;
    }

    /**
     * Get the access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->http->getAccessToken();
    }

    /**
     * Unset the current access token.
     *
     * @return $this
     */
    public function unsetAccessToken(): Client
    {
        $this->http->unsetAccessToken();

        return $this;
    }

    /**
     * Register a callback to be executed before each request.
     *
     * @param Closure $callback
     * @return $this
     */
    public function preflight(Closure $callback): self
    {
        $this->http->setPreflightCallback($callback);

        return $this;
    }

    public function authentication(): Authentication
    {
        return new Authentication($this);
    }
}