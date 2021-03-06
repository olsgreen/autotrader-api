<?php

namespace Olsgreen\AutoTrader\Api\Enums;

abstract class AbstractEnum implements Enum
{
    public function all(): array
    {
        $reflect = new \ReflectionClass(static::class);

        return $reflect->getConstants();
    }

    public function diff(array $values): array
    {
        $available = $this->all();

        return array_diff($values, $available);
    }

    public function contains($value): bool
    {
        $values = (array) $value;

        return count($this->diff($values)) === 0;
    }
}