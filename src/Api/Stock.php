<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\StockItemRequestBuilder;
use Olsgreen\AutoTrader\Api\Builders\StockSearchRequestBuilder;
use Olsgreen\AutoTrader\Api\Exceptions\DuplicateStockException;
use Olsgreen\AutoTrader\Http\Exceptions\ClientException;
use Olsgreen\AutoTrader\Http\SimpleMultipartBody;

class Stock extends AbstractApi
{
    /**
     * Create a stock item.
     *
     * @param string $advertiserId
     * @param        $request      StockItemRequestBuilder|array
     *
     * @return array
     */
    public function create(string $advertiserId, $request): array
    {
        if (is_array($request)) {
            $request = new StockItemRequestBuilder($request);
        } elseif (!($request instanceof StockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or StockItemRequestBuilder.'
            );
        }

        try {
            return $this->_post(
                '/stock',
                ['advertiserId' => $advertiserId],
                $request->toJson(),
                ['Content-Type' => 'application/json']
            );
        } catch (ClientException $ex) {
            if ($ex->getResponse()->getStatusCode() === 409) {
                throw new DuplicateStockException(
                    'Duplicate stock found.',
                    $ex->getRequest(),
                    $ex->getResponse(),
                    $ex
                );
            }

            throw $ex;
        }
    }

    /**
     * Update a stock item.
     *
     * @param string $advertiserId
     * @param string $uuid
     * @param        $request
     *
     * @return array
     */
    public function update(string $advertiserId, string $uuid, $request): array
    {
        if (is_array($request)) {
            $request = new StockItemRequestBuilder($request);
        } elseif (!($request instanceof StockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or StockItemRequestBuilder.'
            );
        }

        return $this->_patch(
            '/stock/'.$uuid,
            ['advertiserId' => $advertiserId],
            $request->toJson(),
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Retrieve a stock item.
     *
     * @param string $advertiserId
     * @param string $uuid
     *
     * @return array
     */
    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/stock/'.$uuid,
            ['advertiserId' => $advertiserId],
        );
    }

    /**
     * Upload an image file.
     *
     * @param string $advertiserId
     * @param string $path
     *
     * @throws \Exception
     *
     * @return string
     */
    public function uploadImage(string $advertiserId, string $path): string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new \Exception(
                sprintf('The path is not readable [%s]', $path)
            );
        }

        $data = fopen($path, 'r');

        return $this->uploadImageData($advertiserId, $data);
    }

    /**
     * Upload image binary data.
     *
     * @param string $advertiserId
     * @param        $data|resource
     *
     * @return string
     */
    public function uploadImageData(string $advertiserId, $data): string
    {
        $body = new SimpleMultipartBody();
        $body->add('file', $data, 'image.jpg', ['Content-Type' => 'image/jpeg']);

        $response = $this->_post(
            '/images',
            ['advertiserId' => $advertiserId],
            $body
        );

        return $response['imageId'];
    }

    /**
     * Search an advertisers stock.
     *
     * @param string $advertiserId
     * @param        $request
     *
     * @return array
     */
    public function search(string $advertiserId, $request): array
    {
        if (!($request instanceof StockSearchRequestBuilder)) {
            if (is_array($request)) {
                $request = StockSearchRequestBuilder::create($request);
            }

            // Throw an invalid argument exception if it's anything else.
            else {
                throw new \InvalidArgumentException(
                    'The $request argument must be an array or StockSearchRequestBuilder.'
                );
            }
        }

        $params = array_merge($request->toArray(), [
            'advertiserId' => $advertiserId,
        ]);

        return $this->_get('/stock', $params);
    }
}
