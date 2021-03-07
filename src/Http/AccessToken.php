<?php

namespace Olsgreen\AutoTrader\Http;

use DateTime;

class AccessToken implements \JsonSerializable
{
    protected $access_token;

    protected $expires;

    public function __construct(array $data)
    {
        if (!empty($data['access_token'])) {
            $this->access_token = $data['access_token'];
        }

        if (!empty($data['expires'])) {
            $this->expires = $data['expires'];
        }
    }

    public function hasExpired(): bool
    {
        return $this->getExpires() < new DateTime();
    }

    public function getToken(): string
    {
        return $this->access_token;
    }

    public function getExpires(): DateTime
    {
        return new DateTime($this->expires);
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->access_token,
            'expires'      => $this->getExpires()
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
