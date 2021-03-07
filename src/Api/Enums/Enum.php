<?php

namespace Olsgreen\AutoTrader\Api\Enums;

interface Enum
{
    public function all(): array;

    public function diff(array $values): array;

    public function contains($value): bool;
}
