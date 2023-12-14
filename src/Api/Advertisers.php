<?php

namespace Olsgreen\AutoTrader\Api;

class Advertisers extends AbstractApi
{
    public function get(bool $autotraderAdvertAllowances = false)
    {
        return $this->_get('/advertisers', [
            'autotraderAdvertAllowances' => $autotraderAdvertAllowances ? 'true' : 'false'
        ]);
    }
}