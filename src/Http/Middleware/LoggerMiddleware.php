<?php

namespace Olsgreen\AutoTrader\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class LoggerMiddleware implements MiddlewareInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function prepareRequest(RequestInterface $request)
    {
        return json_encode([
            'uri'     => $request->getUri(),
            'method'  => $request->getMethod(),
            'headers' => $request->getHeaders(),
            'body'    => (string) $request->getBody(),
        ], JSON_PRETTY_PRINT);
    }

    protected function prepareResponse(ResponseInterface $response)
    {
        $contentType = 'text/plain';

        if ($response->hasHeader('Content-Type')) {
            $contentType = $response->getHeader('Content-Type')[0];
        }

        $parsedBody = 'Logging for '.$contentType.' is not enabled.';

        switch ($contentType) {
            case 'application/json':
                $body = (string) $response->getBody();
                $parsedBody = json_decode($body, true);
                break;
            case 'text/plain':
                $parsedBody = (string) $response->getBody();
                break;
        }

        return json_encode([
            'responseCode'   => $response->getStatusCode(),
            'responseReason' => $response->getReasonPhrase(),
            'header'         => $response->getHeaders(),
            'body'           => $parsedBody,
        ], JSON_PRETTY_PRINT);
    }

    public function peel($request, \Closure $next)
    {
        try {
            $response = $next($request);
        } catch (\Exception $exception) {
            if (method_exists($exception, 'getResponse')) {
                $response = $exception->getResponse();
            }
        }

        $data = $this->prepareRequest($request).PHP_EOL.$this->prepareResponse($response);

        $this->logger->debug('API Request: '.$request->getUri().PHP_EOL.$data);

        if (isset($exception)) {
            throw $exception;
        }

        return $response;
    }
}
