<?php

namespace Olsgreen\AutoTrader\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * GuzzleClient
 * An client implementation that wraps GuzzleHTTP to provide HTTP communication.
 */
class GuzzleClient extends AbstractClient implements ClientInterface
{
    /**
     * Guzzle HTTP Client Instance.
     *
     * @var Client|GuzzleClientInterface|null
     */
    protected $guzzle;

    /**
     * GuzzleClient constructor.
     *
     * @param GuzzleClientInterface|null $guzzle
     */
    public function __construct(GuzzleClientInterface $guzzle = null)
    {
        if (!$guzzle) {
            $guzzle = new Client();
        }

        $this->guzzle = $guzzle;
    }

    /**
     * Create a request object instance.
     *
     * @param string $method
     * @param string $uri
     * @param array  $params
     * @param null   $body
     * @param array  $headers
     *
     * @return Request
     */
    protected function createRequestObject(
        string $method,
        string $uri,
        array $params = [],
        $body = null,
        array $headers = []
    ): RequestInterface {
        $this->doPreflightCallback($method, $uri, $headers, $body);

        $headers = array_merge($this->headers, $headers);

        $uri = $this->baseUri.$uri.'?'.http_build_query($params);

        return new Request($method, $uri, $headers, $body);
    }

    /**
     * Execute a GET request.
     *
     * @param string $uri
     * @param array  $params
     * @param array  $headers
     * @param null   $sink    string|resource|StreamInterface
     *
     * @throws GuzzleException
     *
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = [], $sink = null): ResponseInterface
    {
        $request = $this->createRequestObject('GET', $uri, $params, null, $headers);

        $options = [];

        if ($sink) {
            // Save the response body to resource, stream, path.
            $options[RequestOptions::SINK] = $sink;
        }

        return $this->sendRequest($request, $options);
    }

    /**
     * Execute a POST request.
     *
     * @param string $uri
     * @param array  $params
     * @param null   $body
     * @param array  $headers
     *
     * @throws GuzzleException
     *
     * @return ResponseInterface
     */
    public function post(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface
    {
        if ($body instanceof SimpleMultipartBody) {
            $body = new MultipartStream($body->toArray());
        } elseif ($body instanceof UrlEncodedFormBody) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            $body = $body->encode();
        }

        $request = $this->createRequestObject('POST', $uri, $params, $body, $headers);

        return $this->sendRequest($request);
    }

    /**
     * Execute a PUT request.
     *
     * @param string $uri
     * @param array  $params
     * @param null   $body
     * @param array  $headers
     *
     * @throws GuzzleException
     *
     * @return ResponseInterface
     */
    public function put(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface
    {
        $request = $this->createRequestObject('PUT', $uri, $params, $body, $headers);

        return $this->sendRequest($request);
    }

    /**
     * Execute a PATCH request.
     *
     * @param string $uri
     * @param array  $params
     * @param null   $body
     * @param array  $headers
     *
     * @throws GuzzleException
     *
     * @return ResponseInterface
     */
    public function patch(string $uri, array $params = [], $body = null, array $headers = []): ResponseInterface
    {
        $request = $this->createRequestObject('PATCH', $uri, $params, $body, $headers);

        return $this->sendRequest($request);
    }

    /**
     * Execute a DELETE request.
     *
     * @param string $uri
     * @param array  $params
     * @param array  $headers
     *
     * @throws GuzzleException
     *
     * @return ResponseInterface
     */
    public function delete(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        $request = $this->createRequestObject('DELETE', $uri, $params, null, $headers);

        return $this->sendRequest($request);
    }

    /**
     * Process the middleware and send the requet.
     *
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return ResponseInterface
     */
    private function sendRequest(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->processMiddleware($request, function ($request) use ($options) {
            return $this->guzzle->send($request, $options);
        });
    }
}
