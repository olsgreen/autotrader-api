<?php

namespace Olsgreen\AutoTrader\Api\Exceptions;

use Olsgreen\AutoTrader\Http\Exceptions\ClientException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BadRequestException extends ClientException
{
    protected array $warnings = [];

    public function __construct(string $message, Request $request, ?Response $response = null, ?\Exception $previous = null)
    {
        if ($response) {
            $body = json_decode($response->getBody(), true);

            $this->warnings = $body['warnings'] ?? [];
        }

        parent::__construct($message, $request, $response, $previous);
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function warningsContain(string $pattern): bool
    {
        $pattern = preg_quote($pattern);

        foreach ($this->warnings as $message) {
            if (preg_match("/$pattern/i", $message)) {
                return true;
            }
        }

        return false;
    }
}
