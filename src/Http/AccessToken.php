<?php

namespace Olsgreen\AutoTrader\Http;

use DateTime;

class AccessToken implements \JsonSerializable
{
    protected $access_token;

    protected $expires_at;

    public function __construct(array $data)
    {
        if (!empty($data['access_token'])) {
            $this->access_token = $data['access_token'];
        }

        if (!empty($data['expires_at'])) {
            $this->expires_at = $data['expires_at'];
        }
    }

    public function hasExpired(): bool
    {
        return $this->getExpiresAt() < new DateTime();
    }

    public function getToken(): string
    {
        return $this->access_token;
    }

    /**
     * @deprecated Use getExpiresAt() - this method will be removed in the next major version
     */
    public function getExpires(): DateTime
    {
        return $this->getExpiresAt();
    }

    public function getExpiresAt(): DateTime
    {
        return new DateTime($this->expires_at);
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->access_token,
            'expires_at'      => $this->getExpiresAt()
                ->format(DateTime::ATOM),
            /**
             * @deprecated `expires` will be removed in the next major version
             */
            'expires'      => $this->getExpiresAt()
                ->format(DateTime::ATOM),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->jsonSerialize());
    }

    public function __toString(): string
    {
        return $this->getToken();
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
