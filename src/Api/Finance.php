<?php

namespace Olsgreen\AutoTrader\Api;

class Finance extends AbstractApi
{
    public function applications(): FinanceApplication
    {
        return new FinanceApplication($this->client);
    }
}
