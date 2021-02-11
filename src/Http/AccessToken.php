<?php


namespace Olsgreen\AutoTrader\Http;

use DateTime;

class AccessToken implements \ArrayAccess, \JsonSerializable
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
            'expires' => $this->getExpires()
                ->format(DateTime::ATOM),
        ];
    }



    public function toJson(): string
    {
        return $this->jsonSerialize();
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    private function isValidOffset($offest): bool
    {
        return in_array($offest, ['access_token', 'expires']);
    }

    public function offsetExists($offset)
    {
        if ($this->isValidOffset($offset)) {
            return isset($this->$offset);
        }

        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->isValidOffset($offset)) {
            return $this->$offset;
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        if ($this->isValidOffset($offset)) {
            $this->$offset = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if ($this->isValidOffset($offset)) {
            $this->$offset = null;
        }
    }

    public function jsonSerialize(): string
    {
        return json_encode($this->toArray());
    }
}