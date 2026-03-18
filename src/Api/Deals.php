<?php

namespace Olsgreen\AutoTrader\Api;

class Deals extends AbstractApi
{
    public function get(string $advertiserId): array
    {
        return $this->_get(
            '/deals',
            ['advertiserId' => $advertiserId],
        );
    }

    public function show(string $advertiserId, string $uuid): array
    {
        return $this->_get(
            '/deals/'.$uuid,
            ['advertiserId' => $advertiserId],
        );
    }

    public function complete(string $advertiserId, string $uuid): void
    {
        $this->_patch(
            '/deals/'.$uuid,
            ['advertiserId' => $advertiserId],
            json_encode(['advertiserDealStatus' => 'Complete']),
            ['Content-Type' => 'application/json']
        );
    }

    public function cancel(string $advertiserId, string $uuid, string $reason, ?string $notes = null): void
    {
        $this->_patch(
            '/deals/'.$uuid,
            ['advertiserId' => $advertiserId],
            json_encode(array_filter([
                'advertiserDealStatus'         => 'Cancelled',
                'advertiserCancellationReason' => $reason,
                'advertiserCancellationNotes'  => $notes,
            ])),
            ['Content-Type' => 'application/json']
        );
    }
}
