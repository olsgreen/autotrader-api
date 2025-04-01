<?php

namespace Olsgreen\AutoTrader;

use Closure;
use Olsgreen\AutoTrader\Http\ClientInterface;
use Olsgreen\AutoTrader\Http\GuzzleClient;

abstract class AbstractClient
{
    /**
     * HTTP Client Instance.
     *
     * @var ClientInterface
     */
    protected $http;

    /**
     * Client constructor.
     *
     * @param array                $options
     * @param ClientInterface|null $http
     */
    public function __construct(array $options = [], ?ClientInterface $http = null)
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
    abstract protected function configureFromArray(array $options): AbstractClient;

    /**
     * Register a callback to be executed before each request.
     *
     * @param Closure $callback
     *
     * @return $this
     */
    public function preflight(Closure $callback): self
    {
        $this->http->setPreflightCallback($callback);

        return $this;
    }
}
