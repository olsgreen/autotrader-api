<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\Enum;

class AbstractSchemableBuilder extends AbstractBuilder
{
    /**
     * Attribute data.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Attribute schema.
     *
     * @var array
     */
    protected $schema = [];

    protected $cast = [];

    private function getEnums(array $array): array
    {
        return array_filter($array, function ($item) {
            if (!class_exists($item)) {
                return false;
            }

            $implements = class_implements($item);

            return in_array(Enum::class, $implements);
        });
    }

    private function isEnumArray(array $array): bool
    {
        return count($this->getEnums($array)) > 0;
    }

    protected function attributeEmpty($key): bool
    {
        return empty($key) && empty($this->attributes[$key]);
    }

    protected function validateAttributeValue(string $key, $value, bool $allowEmpty = true): void
    {
        if (!empty($value) || !$allowEmpty) {
            $validator = $this->schema[$key];

            /**
             * Validate enum based attributes.
             */
            if ($this->isEnumArray((array) $validator)) {
                $enums = array_map(function ($enum) {
                    return (new $enum())->all();
                }, $this->getEnums((array) $validator));

                if (!in_array($value, array_flatten($enums))) {
                    throw new \InvalidArgumentException(
                        sprintf('"%s" is not a valid value for the attribute "%s".', $value, $key)
                    );
                }

                return;
            }

            /**
             * Validate other attributes.
             */
            switch ($validator) {
                case 'string':
                case 'integer':
                case 'float':
                case 'bool':
                case 'double':
                    $func = 'is_'.$validator;
                    if (!$func($value)) {
                        throw new \InvalidArgumentException(
                            sprintf('"%s" must be a %s value it is a %s.', $key, $validator, gettype($value))
                        );
                    }
                    break;
                case 'date':
                    $date = \DateTime::createFromFormat('Y-m-d', $value);
                    if (!$date) {
                        throw new \InvalidArgumentException(
                            sprintf('"%s" must be a valid date in Y-m-d format.', $key)
                        );
                    }
                    break;
                default:
                    throw new \InvalidArgumentException(
                        sprintf("There is no validator registered for '%s'", $validator)
                    );
            }
        }
    }

    private function shouldCast(string $key): bool
    {
        return in_array($key, $this->cast);
    }

    private function cast(string $type, $value)
    {
        if (is_null($value)) {
            return null;
        }

        $castable = ['string', 'integer', 'float', 'bool', 'double'];

        if (!in_array($type, $castable)) {
            throw new \InvalidArgumentException(
                sprintf('%s is not a castable type.', $type)
            );
        }

        $type = str_replace(['integer', 'string'], ['int', 'str'], $type);

        $method = $type.'val';

        return $method($value);
    }

    /**
     * Sets an attribute.
     *
     * @param string $key
     * @param $value
     *
     * @return AbstractSchemableBuilder
     */
    public function setAttribute(string $key, $value): AbstractSchemableBuilder
    {
        if ($this->shouldCast($key)) {
            $value = $this->cast($this->schema[$key], $value);
        }

        if (array_key_exists($key, $this->schema)) {
            $this->validateAttributeValue($key, $value);

            $this->attributes[$key] = $value;
        }

        return parent::setAttribute($key, $value);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get the builders array representation.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    public function __call($name, $args)
    {
        $attributeName = $this->getAttributeName($name);

        if (in_array($attributeName, $this->schema)) {
            $startsWith = substr($name, 0, 3);
            if ($startsWith === 'set' && count($args) === 1) {
                $this->attributes[$attributeName] = array_shift($args);

                return $this;
            } elseif ($startsWith === 'get' && count($args) === 0) {
                return $this->attributes[$attributeName];
            }
        }

        throw new \Error('Call to undefined method');
    }
}
