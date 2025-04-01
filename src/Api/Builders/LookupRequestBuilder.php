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

    /**
     * VIN.
     *
     * @var string
     */
    protected $vin;

    protected $flagsEnum = VehicleLookupFlags::class;

    /**
     * Mileage.
     *
     * @var string|int
     */
    protected $odometerReadingMiles;

    protected $requiredAttributes = [];

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
     * Set the VIN.
     *
     * @param string $vin
     *
     * @return $this
     */
    public function setVin(string $vin): LookupRequestBuilder
    {
        $this->vin = $vin;

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

        // Require a registration or VIN
        if (empty($this->registration) && empty($this->vin)) {
            throw new ValidationException('A registration or VIN must be set.');
        }

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
            'registration'         => !empty($this->registration) ? preg_replace('/\s/', '', $this->registration) : null,
            'vin'                  => !empty($this->vin) ? preg_replace('/\s/', '', $this->vin) : null,
            'odometerReadingMiles' => $this->odometerReadingMiles,
        ] + $this->transformFlags($this->flags));
    }
}
