<?php

namespace Olsgreen\AutoTrader\Api;

class PartExchanges extends AbstractApi
{
    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/part-exchange/'.$uuid,
            ['advertiserId' => $advertiserId],
        );
    }
}
