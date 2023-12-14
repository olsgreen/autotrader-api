<?php

namespace Olsgreen\AutoTrader;

class WebhookHashValidator
{
    protected string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function validate(string $hash, string $timestamp, string $body): bool
    {
        $computedHash = hash_hmac('sha256', "$timestamp.$body", $this->secret);

        return strcmp($hash, $computedHash) === 0;
    }
}
