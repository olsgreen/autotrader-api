<?php

namespace Olsgreen\AutoTrader\Api\Builders;

interface BuilderInterface
{
    /**
     * Validate the builders attributes.
     *
     * @return mixed
     */
    public function validate();

    /**
     * Validate, prepare and return an array formatted
     * representation of the request.
     *
     * @throws ValidationException
     *
     * @return array
     */
    public function toArray(): array;

    public function getFriendlyName(): string;
}
