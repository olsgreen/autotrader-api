<?php


namespace Olsgreen\AutoTrader\Http;

use Closure;
use Optimus\Onion\Onion;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * AbstractClient
 * Base client that implements non-driver specific
 * functionality to provide HTTP communication.
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * The base URI to perform all requests.
     *
     * @var string
     */
    protected $baseUri = '';

    /**
     * Global headers for all requests.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * A closure to execute before every request.
     *
     * @var Closure
     */
    protected $preflightCallback;

    /**
     * Access token to set for each request.
     *
     * @var mixed
     */
    protected $accessToken;

    /**
     * Middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Set the clients base URI.
     *
     * @param string $uri
     * @return ClientInterface
     */
    public function setBaseUri(string $uri): ClientInterface
    {
        $this->baseUri = $uri;

        return $this;
    }

    /**
     * Get the clients base URI.
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * Add a global header.
     *
     * @param string $key
     * @param string $value
     * @return ClientInterface
     */
    public function withHeader(string $key, string $value): ClientInterface
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Get the current global headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Unset global header index.
     *
     * @param string $key
     * @return ClientInterface
     */
    public function unsetHeader(string $key): ClientInterface
    {
        unset($this->headers[$key]);

        return $this;
    }

    /**
     * Set the access token.
     *
     * @param $token
     * @return ClientInterface
     */
    public function setAccessToken($token): ClientInterface
    {
        $this->accessToken = $token;

        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }

    /**
     * Unset the current access token.
     *
     * @return ClientInterface
     */
    public function unsetAccessToken(): ClientInterface
    {
        $this->accessToken = null;

        $this->unsetHeader('Authorization');

        return $this;
    }

    /**
     * Get the access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the callback to be performed before every request.
     *
     * @param Closure $callback
     * @return ClientInterface
     */
    public function setPreflightCallback(Closure $callback): ClientInterface
    {
        $this->preflightCallback = $callback;

        return $this;
    }

    /**
     * Execute the preflight callback.
     *
     * @param $method
     * @param $uri
     * @param $headers
     * @param $body
     * @return ClientInterface
     */
    protected function doPreflightCallback(&$method, &$uri, &$headers, &$body): ClientInterface
    {
        if ($this->preflightCallback) {
            call_user_func_array(
                $this->preflightCallback,
                [&$method, &$uri, &$headers, &$body, $this]
            );
        }

        return $this;
    }

    /**
     * Set the global middleware stack.
     *
     * @param array $middleware
     * @return $this
     */
    public function withMiddleware(array $middleware): ClientInterface
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * Get the global middleware stack.
     *
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * Process the global middleware.
     *
     * @param RequestInterface $request
     * @param Closure $dispatch
     * @return ResponseInterface
     */
    protected function processMiddleware(RequestInterface $request, Closure $dispatch): ResponseInterface
    {
        return  (new Onion)->layer($this->middleware)
            ->peel($request, function($request) use ($dispatch) {
                return $dispatch($request);
            });
    }
}