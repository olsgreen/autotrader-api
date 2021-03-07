<?php

namespace Olsgreen\AutoTrader\Api\Builders;

abstract class AbstractBuilder
{
    /**
     * Attribute keys which are required
     * and must not be empty.
     *
     * @var string[]
     */
    protected $requiredAttributes = [];

    /**
     * AbstractBuilder constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public function getFriendlyName(): string
    {
        $class = new \ReflectionClass($this);

        return $class->getShortName();
    }

    /**
     * Factory method.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function create(array $attributes = [])
    {
        return new static($attributes);
    }

    /**
     * Get an setter method name from and attribute name.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getSetterName(string $key): string
    {
        $parts = explode('_', $key);

        $parts = array_map(function ($part) {
            return ucwords($part);
        }, $parts);

        return 'set'.implode('', $parts);
    }

    /**
     * Get an attributes name from a setter method name.
     *
     * @param string $setter
     *
     * @return string
     */
    protected function getAttributeName(string $setter): string
    {
        $setter = substr($setter, 3);

        $parts = preg_split('/(?=[A-Z])/', $setter, -1, PREG_SPLIT_NO_EMPTY);

        $parts = array_map('strtolower', $parts);

        return implode('_', $parts);
    }

    /**
     * Set the objects attributes from array.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = []): AbstractBuilder
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    private function attributeIsBuilder(string $key): bool
    {
        return property_exists($this, $key) &&
            $this->$key instanceof AbstractBuilder;
    }

    public function setAttribute(string $key, $value): AbstractBuilder
    {
        // Set values that have defined setters.
        $setter = $this->getSetterName($key);

        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif ($this->attributeIsBuilder($key)) {
            $this->$key->setAttributes($value);
        }

        return $this;
    }

    /**
     * Remove empty values from the prepare methods output.
     *
     * @param array $output
     *
     * @return array]
     */
    protected function filterPrepareOutput(array $output)
    {
        /*return array_filter($output, function($item) {
            return !is_null($item);
        });*/
        return array_filter($output, function ($item) {
            return isset($item) && !(is_array($item) && empty($item));
        });
    }

    public function getRequiredAttributes(): array
    {
        return $this->requiredAttributes;
    }

    public function setRequiredAttributes(array $keys): AbstractBuilder
    {
        $this->requiredAttributes = $keys;

        return $this;
    }

    protected function attributeEmpty($key): bool
    {
        return empty($key);
    }

    public function validate(): bool
    {
        foreach ($this->requiredAttributes as $key) {
            if ($this->attributeEmpty($this->$key)) {
                throw new ValidationException($this->getFriendlyName().": $key must not be empty.");
            }
        }

        return true;
    }

    abstract public function toArray(): array;

    public function toJson($options = null)
    {
        return json_encode($this->toArray(), $options);
    }

    protected function dataGet(array $array, $key, $default = false)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}
