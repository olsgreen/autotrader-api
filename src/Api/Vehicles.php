<?php


namespace Olsgreen\AutoTrader\Api;


use Olsgreen\AutoTrader\Api\Enums\VehicleLookupFlags as LookupFlags;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Vehicles extends AbstractApi
{
    /**
     * Lookup vehicle Base Information
     *
     * This endpoint is used to look up UK registered vehicles and returns core vehicle data.
     * This endpoint also has the ability to return additional data by including a series of
     * additional data parameters, these can be added individually or concurrently.
     *
     * Note that the VehicleLookupFlags::VEHICLE_METRICS & VehicleLookupFlags::VALUATIONS flags
     * also require the current mileage to be passed in as the last parameter.
     *
     * The flags array can consist of the following:
     *
     * - VehicleLookupFlags::MOT_TESTS
     *   Provides most recent MOT test information for the specified vehicle.
     *
     * - VehicleLookupFlags::FEATURES
     *   Provides an array of standard and possible optional features for the specified vehicle.
     *
     * - VehicleLookupFlags::BASIC_VEHICLE_CHECK
     *   Provides a variety of vehicle specific provenance data.
     *
     * - VehicleLookupFlags::FULL_VEHICLE_CHECK
     *   Provides a variety of vehicle specific provenance data.
     *
     * - VehicleLookupFlags::VALUATIONS
     *   Provides a variety of Auto Trader valuations for the specified vehicle.
     *
     * - VehicleLookupFlags::VEHICLE_METRICS
     *   Provides a variety of Auto Trader valuations and vehicle metrics for the specified vehicle.
     *
     * - VehicleLookupFlags::COMPETITORS
     *   Provides a pre-constructed URL, allowing users to explore market competition.
     *
     * @param string $vrm
     * @param string|array $flags
     * @param string"int $odometerReadingMiles
     * @return array
     */
    public function lookup(string $vrm, $flags = [], $odometerReadingMiles = null): array
    {
        $resolver = new OptionsResolver();

        $requiresOdometerReading = !empty(array_intersect(
            [LookupFlags::VALUATIONS, LookupFlags::VEHICLE_METRICS], (array) $flags
        ));

        // Prepare the payload.
        $payload = ['registration' => preg_replace('/\s/', '', $vrm)];

        foreach ((array) $flags as $flag) {
            $payload[$flag] = true;
        }

        if (isset($odometerReadingMiles)) {
            $payload['odometerReadingMiles'] = $odometerReadingMiles;
        }

        // Configure the option validator / resolver.
        $resolver->setDefined('registration')
            ->setAllowedTypes('registration', 'string')
            ->setRequired('registration');

        foreach ((new LookupFlags)->all() as $key) {
            $resolver->setDefined($key)
                ->setAllowedTypes($key, 'boolean')
                ->setNormalizer($key, $this->booleanNormalizer());
        }

        $resolver->setDefined('odometerReadingMiles')
            ->setAllowedTypes('odometerReadingMiles', ['string', 'numeric'])
            ->setAllowedValues('odometerReadingMiles', function($value) {
                return intval($value) > 1000;
            });

        if ($requiresOdometerReading) {
            $resolver->setRequired('odometerReadingMiles');
        }

        return $this->_get('/service/stock-management/vehicles', $resolver->resolve($payload));
    }
}