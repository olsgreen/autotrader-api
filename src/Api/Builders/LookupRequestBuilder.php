<?php


namespace Olsgreen\AutoTrader\Api\Builders;


use Olsgreen\AutoTrader\Api\Enums\VehicleLookupFlags;

class LookupRequestBuilder extends AbstractBuilder implements BuilderInterface
{
    /**
     * Registration.
     *
     * @var string
     */
    protected $registration;

    /**
     * Dataset Flags.
     *
     * @var array
     */
    protected $flags = [];

    /**
     * Mileage.
     *
     * @var string|integer
     */
    protected $odometerReadingMiles;

    /**
     * Get the registration.
     *
     * @return string
     */
    public function getRegistration(): string
    {
        return $this->registration;
    }

    /**
     * Set the registration.
     *
     * @param string $registration
     * @return $this
     */
    public function setRegistration(string $registration): LookupRequestBuilder
    {
        $this->registration = $registration;

        return $this;
    }

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
     * @return $this
     * @throws \Exception
     */
    public function setFlags(array $flags): LookupRequestBuilder
    {
        $flagsList = new VehicleLookupFlags();

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
     * Get the mileage.
     *
     * @return string|null
     */
    public function getOdometerReadingMiles(): ?string
    {
        return $this->odometerReadingMiles;
    }

    /**
     * Set the mileage.
     *
     * @param $miles
     * @return $this
     */
    public function setOdometerReadingMiles($miles): LookupRequestBuilder
    {
        $this->odometerReadingMiles = $miles;

        return $this;
    }

    /**
     * Validate the requests attributes.
     *
     * @return bool
     * @throws ValidationException
     */
    public function validate(): bool
    {
        // Ensure the registration is set.
        if (empty($this->registration)) {
            throw new ValidationException(
                'The `registration` attribute must be a valid UK vehicle registration mark.'
            );
        }

        // Validate the odometer status.
        $requiresOdometerReading = !empty(array_intersect(
            [VehicleLookupFlags::VALUATIONS, VehicleLookupFlags::VEHICLE_METRICS],
            $this->getFlags()
        ));

        if ($requiresOdometerReading && empty($this->odometerReadingMiles)) {
            throw new ValidationException(
                'The attribute `odometerReadingMiles` must be set if the VehicleLookupFlags::VALUATIONS' .
                ' or VehicleLookupFlags::VEHICLE_METRICS flags are set.'
            );
        }

        return true;
    }

    /**
     * Transform the dataset flags into the
     * format the API recognises.
     *
     * @param array $flags
     * @return array
     */
    private function transformFlags(array $flags): array
    {
        $tranformed = [];

        foreach ($flags as $flag) {
            $tranformed[$flag] = 'true';
        }

        return $tranformed;
    }

    /**
     * Validate, prepare and return an array formatted
     * representation of the request.
     *
     * @return array
     * @throws ValidationException
     */
    public function prepare(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'registration' => $this->registration,
            'odometerReadingMiles' => $this->odometerReadingMiles,
        ] + $this->transformFlags($this->flags));
    }
}