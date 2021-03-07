<?php

namespace Olsgreen\AutoTrader;

trait ManagesHttpAccessTokens
{
    /**
     * Get the access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->http->getAccessToken();
    }

    /**
     * Set the access token.
     *
     * @param $token
     *
     * @return $this
     */
    public function setAccessToken($token): AbstractClient
    {
        $this->http->setAccessToken($token);

        return $this;
    }

    /**
     * Unset the current access token.
     *
     * @return $this
     */
    public function unsetAccessToken(): Client
    {
        $this->http->unsetAccessToken();

        return $this;
    }
}
