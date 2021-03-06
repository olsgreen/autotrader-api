<?php


namespace Olsgreen\AutoTrader\Api;


class Adverts extends AbstractApi
{
    public function search()
    {

        return $this->_get('/service/stock-management/search');
    }
}