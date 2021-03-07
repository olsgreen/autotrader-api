<?php

namespace Olsgreen\AutoTrader\Http\Middleware;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseRecorder implements MiddlewareInterface
{
    protected $path;

    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new \Exception(
                sprintf('The path does not exist. [%s]', $path)
            );
        }

        if (!is_writable($path)) {
            throw new \Exception(
                sprintf('The path is not writable. [%s]', $path)
            );
        }

        $this->path = $path;
    }

    protected function getPrettyBody(MessageInterface $message)
    {
        $body = (string) $message->getBody();

        $contentType = $message->getHeaderLine('Content-Type');

        $isJson = stripos($contentType, 'application/json') > -1;

        if ($isJson) {
            $decoded = json_decode($body, JSON_PRETTY_PRINT);

            if (!json_last_error()) {
                $body = $decoded;
            }
        }

        return $body;
    }

    protected function prepare(RequestInterface $request, ResponseInterface $response)
    {
        return json_encode([
            'request' => [
                'method'  => $request->getMethod(),
                'uri'     => $request->getUri(),
                'headers' => $request->getHeaders(),
                'body'    => $this->getPrettyBody($request),
            ],
            'response' => [
                'responseCode' => $response->getStatusCode(),
                'headers'      => $response->getHeaders(),
                'body'         => $this->getPrettyBody($response),
            ],
        ], JSON_PRETTY_PRINT);
    }

    public function peel($request, \Closure $next)
    {
        $response = $next($request);

        $replace = ['/', ':', '=', '?', '&', '.'];

        $handle = $request->getMethod().'-'.$request->getUri();

        $filename = str_replace($replace, '-', $handle).'.json';

        $pathname = $this->path.DIRECTORY_SEPARATOR.$filename;

        file_put_contents(
            $pathname,
            $this->prepare($request, $response)
        );

        return $response;
    }
}
