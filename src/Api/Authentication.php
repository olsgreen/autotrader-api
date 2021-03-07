<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Http\AccessToken;
use Olsgreen\AutoTrader\Http\UrlEncodedFormBody;

class Authentication extends AbstractApi
{
    /**
     * Get an access token from a key and secret.
     *
     * @param string $key
     * @param string $secret
     *
     * @return AccessToken
     */
    public function getAccessToken(string $key, string $secret): AccessToken
    {
        $body = new UrlEncodedFormBody([
            'key'    => $key,
            'secret' => $secret,
        ]);

        $response = $this->_post('/authenticate', [], $body);

        return new AccessToken($response);
    }
}
