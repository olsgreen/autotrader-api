<?php

namespace Olsgreen\AutoTrader\Api;

class Messages extends AbstractApi
{
    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/messages/'.$uuid,
            ['advertiserId' => $advertiserId],
        );
    }

    public function read(string $advertiserId, string $uuid): void
    {
        $this->_patch(
            '/messages/'.$uuid,
            ['advertiserId' => $advertiserId],
            json_encode([
                'advertiserLastReadStatus' => 'Read',
            ]),
            ['Content-Type' => 'application/json']
        );
    }
}
