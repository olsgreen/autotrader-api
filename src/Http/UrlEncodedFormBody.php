<?php


namespace Olsgreen\AutoTrader\Http;


class UrlEncodedFormBody
{
    protected $fields = [];

    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    public function set(string $name, string $value): UrlEncodedFormBody
    {
        $this->fields[$name] = $value;

        return $this;
    }

    public function unset(string $name): void
    {
        unset($this->fields[$name]);
    }

    public function toArray(): array
    {
        return $this->fields;
    }

    public function encode(): string
    {
        return \http_build_query($this->toArray(), '', '&');
    }
}