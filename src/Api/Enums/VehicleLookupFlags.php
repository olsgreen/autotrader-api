<?php


namespace Olsgreen\AutoTrader\Api\Enums;


class VehicleLookupFlags extends AbstractEnum
{
    const MOT_TESTS = 'motTests',
          FEATURES = 'features',
          BASIC_VEHICLE_CHECK = 'basicVehicleCheck',
          FULL_VEHICLE_CHECK = 'fullVehicleCheck',
          VALUATIONS = 'valuations',
          VEHICLE_METRICS ='vehicleMetrics',
          COMPETITORS = 'competitors';
}