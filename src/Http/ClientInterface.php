<?php


namespace Olsgreen\AutoTrader\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Closure;

interface ClientInterface
{
    /**
     * Get the clients base URI.
     *
     * @return string
     */
    public function getBaseUri(): string;

    /**
     * Set the clients base URI.
     *
     * @param string $uri
     * @return ClientInterface
     */
    public function setBaseUri(string $uri): ClientInterface;

    /**
     * Get the current global headers.
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Add a global header.
     *
     * @param string $key
     * @param string $value
     * @return ClientInterface
     */
    public function withHeader(string $key, string $value): ClientInterface;

    /**
     * Unset global header index.
     *
     * @param string $key
     * @return ClientInterface
     */
    public function unsetHeader(string $key): ClientInterface;

    /**
     * Set the access token.
     *
     * @param $token
     * @return ClientInterface
     */
    public function setAccessToken($token): ClientInterface;

    /**
     * Get the access token.
     *
     * @return mixed
     */
    public function getAccessToken();

    /**
     * Unset The current access token.
     *
     * @return ClientInterface
     */
    public function unsetAccessToken(): ClientInterface;

    /**
     * Set the callback to be performed before every request.
     *
     * @param Closure $callback
     * @return ClientInterface
     */
    public function setPreflightCallback(Closure $callback): ClientInterface;

    /**
     * Set the global middleware stack.
     *
     * @param array $middleware
     * @return $this
     */
    public function withMiddleware(array $middleware): ClientInterface;

    /**
     * Execute a GET request.
     *
     * @param string $uri
     * @param array $params
     * @param array $headers
     * @param null $sink string|resource|StreamInterface
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = [], $sink = null): ResponseInterface;

    /**
     * Execute a POST request.
     *
     * @param string $uri
     * @param array $params
     * @param null $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function post(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface;

    /**
     * Execute a PUT request.
     *
     * @param string $uri
     * @param array $params
     * @param null $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function put(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface;

        /**
     * Execute a PATCH request.
     *
     * @param string $uri
     * @param array $params
     * @param null $body
     * @param array $headers
     * @return ResponseInterface
     */
    public function patch(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface;

    /**
     * Execute a DELETE request.
     *
     * @param string $uri
     * @param array $params
     * @param array $headers
     * @return ResponseInterface
     */
    public function delete(string $uri, array $params = [], array $headers = []): ResponseInterface;
}