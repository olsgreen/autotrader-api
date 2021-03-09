<?php

namespace Olsgreen\AutoTrader\Api\Builders;

use Olsgreen\AutoTrader\Api\Enums\VehicleLookupFlags;

class LookupRequestBuilder extends AbstractBuilder implements BuilderInterface
{
    use HasFlags;

    /**
     * Registration.
     *
     * @var string
     */
    protected $registration;

    protected $flagsEnum = VehicleLookupFlags::class;

    /**
     * Mileage.
     *
     * @var string|int
     */
    protected $odometerReadingMiles;

    protected $requiredAttributes = ['registration'];

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
     *
     * @return $this
     */
    public function setRegistration(string $registration): LookupRequestBuilder
    {
        $this->registration = $registration;

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
     *
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
     * @throws ValidationException
     *
     * @return bool
     */
    public function validate(): bool
    {
        parent::validate();

        // Validate the odometer status.
        $requiresOdometerReading = !empty(array_intersect(
            [VehicleLookupFlags::VALUATIONS, VehicleLookupFlags::VEHICLE_METRICS],
            $this->getFlags()
        ));

        if ($requiresOdometerReading && empty($this->odometerReadingMiles)) {
            throw new ValidationException(
                'The attribute `odometerReadingMiles` must be set if the VehicleLookupFlags::VALUATIONS'.
                ' or VehicleLookupFlags::VEHICLE_METRICS flags are set.'
            );
        }

        return true;
    }



    /**
     * Validate, prepare and return an array formatted
     * representation of the request.
     *
     * @throws ValidationException
     *
     * @return array
     */
    public function toArray(): array
    {
        $this->validate();

        return $this->filterPrepareOutput([
            'registration'         => preg_replace('/\s/', '', $this->registration),
            'odometerReadingMiles' => $this->odometerReadingMiles,
        ] + $this->transformFlags($this->flags));
    }
}
