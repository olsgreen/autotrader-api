<?php


namespace Olsgreen\AutoTrader\Api\Builders;


trait HasFlags
{
    /**
     * Dataset Flags.
     *
     * @var array
     */
    protected $flags = [];

    protected $flagsEnum;

    /**
     * Get the dataset flags.
     *
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * Set the dataset flags.
     *
     * @param array $flags
     *
     * @throws \Exception
     *
     * @return AbstractBuilder
     */
    public function setFlags(array $flags): AbstractBuilder
    {
        $flagsList = new $this->flagsEnum();

        if (!$flagsList->contains($flags)) {
            $badFlags = $flagsList->diff($flags);

            throw new \Exception(
                sprintf(
                    'You tried to set invalid flag(s). [%s]',
                    implode(' | ', $badFlags)
                )
            );
        }

        $this->flags = $flags;

        return $this;
    }

    /**
     * Transform the dataset flags into the
     * format the API recognises.
     *
     * @param array $flags
     *
     * @return array
     */
    protected function transformFlags(array $flags): array
    {
        $tranformed = [];

        foreach ($flags as $flag) {
            $tranformed[$flag] = 'true';
        }

        return $tranformed;
    }
}