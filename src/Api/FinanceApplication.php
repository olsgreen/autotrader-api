<?php

namespace Olsgreen\AutoTrader\Api;

class FinanceApplication extends AbstractApi
{
    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/finance/applications/'.$uuid,
            ['advertiserId' => $advertiserId],
        );
    }
}
