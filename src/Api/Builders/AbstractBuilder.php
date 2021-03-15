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
     * Attributes that are allowed to be empty.
     *
     * @var array
     */
    protected $allowEmpty = [];

    /**
     * AbstractBuilder constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Get a friendly human readable name for the class.
     *
     * @return string
     */
    public function getFriendlyName(): string
    {
        $class = new \ReflectionClass($this);

        return $class->getShortName();
    }

    /**
     * Add attribute to the 'empty' whitelist.
     *
     * @param string $key
     *
     * @return $this
     */
    public function allowEmpty(string $key): AbstractBuilder
    {
        $this->allowEmpty[] = $key;

        return $this;
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

    /**
     * Checks whether a given key is that of a child builder.
     *
     * @param string $key
     *
     * @return bool
     */
    private function attributeIsBuilder(string $key): bool
    {
        return property_exists($this, $key) &&
            $this->$key instanceof AbstractBuilder;
    }

    /**
     * Set an attributes value.
     *
     * @param string $key
     * @param $value
     *
     * @return $this
     */
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
     * @return array
     */
    protected function filterPrepareOutput(array $output): array
    {
        return array_filter($output, function ($item, $key) {
            return in_array($key, $this->allowEmpty) ||
                isset($item) && !(is_array($item) && empty($item));
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Get the attributes required to be
     * set for validation.
     *
     * @return string[]
     */
    public function getRequiredAttributes(): array
    {
        return $this->requiredAttributes;
    }

    /**
     * Set the list of attributes required to
     * be set fo validation.
     *
     * @param array $keys
     *
     * @return $this
     */
    public function setRequiredAttributes(array $keys): AbstractBuilder
    {
        $this->requiredAttributes = $keys;

        return $this;
    }

    /**
     * Checks whether an attribute key is empty;.
     *
     * @param $key
     *
     * @return bool
     */
    protected function attributeEmpty($key): bool
    {
        return empty($this->$key);
    }

    /**
     * Validates the state of the builder.
     *
     * @throws ValidationException
     *
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->requiredAttributes as $key) {
            if ($this->attributeEmpty($key)) {
                throw new ValidationException(
                    $this->getFriendlyName().": $key must not be empty."
                );
            }
        }

        return true;
    }

    /**
     * Gets the array representation of the builder.
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Gets the JSON formatted representation of the builder.
     *
     * @param null $options
     *
     * @return false|string
     */
    public function toJson($options = null)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Gets an item from an array returning the
     * default if it does not exist.
     *
     * @param array $array
     * @param $key
     * @param false $default
     *
     * @return false|mixed
     */
    protected function dataGet(array $array, $key, $default = false)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}
