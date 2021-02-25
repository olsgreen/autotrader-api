<?php


namespace Olsgreen\AutoTrader\Api;


use Olsgreen\AutoTrader\Api\Builders\CreateStockItemRequestBuilder;
use Olsgreen\AutoTrader\Api\Builders\UpdateStockItemRequestBuilder;
use Olsgreen\AutoTrader\Http\SimpleMultipartBody;

class Stock extends AbstractApi
{
    public function create($request): array
    {
        if (is_array($request)) {
            $request = new CreateStockItemRequestBuilder($request);
        } elseif (!($request instanceof CreateStockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or CreateStockItemRequestBuilder.'
            );
        }

        $json = json_encode($request->prepare());

        $headers = ['Content-Type' => 'application/json'];

        return $this->_post('/service/stock-management/stock', [], $json, $headers);
    }

    public function update(string $uuid, $request): array
    {
        if (is_array($request)) {
            $request = new UpdateStockItemRequestBuilder($request);
        } elseif (!($request instanceof UpdateStockItemRequestBuilder)) {
            throw new \InvalidArgumentException(
                'The $request argument must be an array or UpdateStockItemRequestBuilder.'
            );
        }

        $json = json_encode($request->prepare());

        $headers = ['Content-Type' => 'application/json'];

        return $this->_post('/service/stock-management/stock/' . $uuid, [], $json, $headers);
    }

    public function show(string $uuid): array
    {
        return $this->_get('/service/stock-management/stock/' . $uuid);
    }

    public function uploadImage($path): string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new \Exception(
                sprintf('The path is not readable [%s]', $path)
            );
        }

        $data = fopen($path, 'r');

        return $this->uploadImageData($data);
    }

    public function uploadImageData($data): string
    {
        $body = new SimpleMultipartBody();
        $body->add('File', $data);

        $response = $this->_post('/service/stock-management/images', [], $body);

        return $response['imageId'];
    }
}