<?php


namespace Olsgreen\AutoTrader\Api;


use Olsgreen\AutoTrader\Api\Builders\CreateStockItemRequestBuilder;
use Olsgreen\AutoTrader\Api\Builders\UpdateStockItemRequestBuilder;
use Olsgreen\AutoTrader\Http\SimpleMultipartBody;

class Stock extends AbstractApi
{
    /**
     * Create a stock item.
     *
     * @param string $advertiserId
     * @param $request CreateStockItemRequestBuilder|array
     * @return array
     */
    public function create(string $advertiserId, $request): array
    {
        if (is_array($request)) {
            $request = new CreateStockItemRequestBuilder($request);
        } elseif (!($request instanceof CreateStockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or CreateStockItemRequestBuilder.'
            );
        }

        return $this->_post(
            '/service/stock-management/stock',
            ['advertiserId' => $advertiserId],
            $request->toJson(),
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Update a stock item.
     *
     * @param string $advertiserId
     * @param string $uuid
     * @param $request
     * @return array
     */
    public function update(string $advertiserId, string $uuid, $request): array
    {
        if (is_array($request)) {
            $request = new UpdateStockItemRequestBuilder($request);
        } elseif (!($request instanceof UpdateStockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or UpdateStockItemRequestBuilder.'
            );
        }

        return $this->_patch(
            '/service/stock-management/stock/' . $uuid,
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
     * @return array
     */
    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/service/stock-management/stock/' . $uuid,
            ['advertiserId' => $advertiserId],
        );
    }

    /**
     * Upload an image file.
     *
     * @param string $advertiserId
     * @param string $path
     * @return string
     * @throws \Exception
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
     * @param $data|resource
     * @return string
     */
    public function uploadImageData(string $advertiserId, $data): string
    {
        $body = new SimpleMultipartBody();
        $body->add('file', $data);

        $response = $this->_post(
            '/service/stock-management/images',
            ['advertiserId' => $advertiserId],
            $body
        );

        return $response['imageId'];
    }
}