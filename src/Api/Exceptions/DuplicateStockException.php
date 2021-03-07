<?php

namespace Olsgreen\AutoTrader\Api\Exceptions;

use Olsgreen\AutoTrader\Http\Exceptions\ClientException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DuplicateStockException extends ClientException
{
    /**
     * @var string|null
     */
    protected $existingStockId;

    /**
     * DuplicateStockException constructor.
     *
     * @param string $message
     * @param Request $request
     * @param Response|null $response
     * @param \Exception|null $previous
     */
    public function __construct(string $message, Request $request, Response $response = null, \Exception $previous = null)
    {
        $this->existingStockId = $this->parseStockIdFromMessage($message);

        parent::__construct($message, $request, $response, $previous);
    }

    /**
     * Parse the stock id from the message.
     *
     * @param string $message
     * @return string|null
     */
    private function parseStockIdFromMessage(string $message):? string
    {
        $pattern = '/Duplicate stock found, stockId=([a-z0-9]+)/i';

        if (preg_match($pattern, $message, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get the stock ID.
     *
     * @return string
     */
    public function getExistingStockId(): string
    {
        return $this->existingStockId;
    }
}