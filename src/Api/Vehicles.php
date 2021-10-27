<?php

namespace Olsgreen\AutoTrader\Api;

use Olsgreen\AutoTrader\Api\Builders\LookupRequestBuilder;

class Vehicles extends AbstractApi
{
    /**
     * Lookup vehicle Base Information.
     *
     * This endpoint is used to look up UK registered vehicles and returns core vehicle data.
     * This endpoint also has the ability to return additional data by including a series of
     * additional data parameters, these can be added individually or concurrently.
     *
     * Note that the VehicleLookupFlags::VEHICLE_METRICS & VehicleLookupFlags::VALUATIONS flags
     * also require the `odimeterReadingMileage` attribute.
     *
     * @see Enums\VehicleLookupFlags for more information on the flags.
     *
     * This method is intended for use in one of three ways:
     *
     * 1) For basic vehicle information lookups by simply specifying the registration:
     *    $basicVehicleData = $api->vehicles()->lookup('EO66XXX')
     *
     * 2) For more complex requests with multiple flags via array:
     *    $request = [
     *      'registration' => 'EO66XXX',
     *      'odimeterReadingMileage' => 35000,
     *      'flags' => [VehicleLookupFlags::VALUATIONS]
     *    ];
     *
     *    $vehicleDataWithValuation = $api->vehicles()->lookup($request);
     *
     *  3) For complex requests using the builder:
     *     $request = LookupRequestBuilder::create()
     *          ->setRegistration('EO66XXX')
     *          ->setOdimeterReadingMileage(35000)
     *          ->setFlags([
     *              VehicleLookupFlags::VALUATIONS,
     *              VehicleLookupFlags::VEHICLE_METRICS
     *           ]);
     *
     *     $vehicleMetricsValuation = $api->vehicles()->lookup(12345, $request);
     *
     * @param $request LookupRequestBuilder|string|array
     *
     * @return array
     */
    public function lookup(string $advertiserId, $request): array
    {
        if (!($request instanceof LookupRequestBuilder)) {
            // Handle lookups for basic vehicle information by registration.
            // i.e. $api->vehicles()->lookup('EO66XXX')
            if (is_string($request)) {
                $request = LookupRequestBuilder::create()
                    ->setRegistration($request);
            }

            // Handle arrays based representations of the request.
            // i.e. $request = [
            //  'registration' => 'EO66XXX',
            //  'flags' => ['valuations', 'mots'],
            //  'odometerReadingMiles' => 35000
            //];
            // $api->vehicles()->lookup($request);
            elseif (is_array($request)) {
                $request = LookupRequestBuilder::create($request);
            }

            // Throw an invalid argument exception if it's anything else.
            else {
                throw new \InvalidArgumentException(
                    'The $request argument must be a string, array or LookupRequestBuilder.'
                );
            }
        }

        $params = array_merge($request->toArray(), [
            'advertiserId' => $advertiserId
        ]);

        return $this->_get('/service/stock-management/vehicles', $params);
    }
}
