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

    abstract public function getFriendlyName(): string;

    /**
     * Factory method.
     *
     * @param array $attributes
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
     * @return string
     */
    private function getSetterName(string $key): string
    {
        $parts = explode('_', $key);

        $parts = array_map(function($part) {
            return ucwords($part);
        }, $parts);

        return 'set' . implode('', $parts);
    }

    /**
     * Set the objects attributes from array.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = []): AbstractBuilder
    {
        foreach ($attributes as $key => $value) {
            $setter = $this->getSetterName($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * Remove empty values from the prepare methods output.
     *
     * @param array $output
     * @return array]
     */
    protected function filterPrepareOutput(array $output)
    {
        return array_filter($output, function($item) {
            return !is_null($item);
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

    public function validate(): bool
    {
        foreach ($this->requiredAttributes as $key) {
            if (empty($this->$key)) {
                throw new ValidationException($this->getFriendlyName() . ": $key must not be empty.");
            }
        }

        return true;
    }
}