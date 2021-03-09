<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\SearchRequestBuilder;

class Adverts extends AbstractApi
{
    /**
     * $request = (new SearchRequestBuilder())
     *     ->setPublicSearch()
     *
     * $request->standardParameters()
     *  ->setDerivativeId(123456)
     *  ->setPostCode('SS54TB')
     *  ->setDistance(10)
     *
     * $api->adverts()->search($request)
     * @return array
     */
    public function search($request): array
    {
        if (!($request instanceof SearchRequestBuilder)) {
            if (is_array($request)) {
                $request = SearchRequestBuilder::create($request);
            }

            // Throw an invalid argument exception if it's anything else.
            else {
                throw new \InvalidArgumentException(
                    'The $request argument must be an array or SearchRequestBuilder.'
                );
            }
        }

        return $this->_get('/service/stock-management/search', $request->toArray());
    }
}
