<?php

namespace Olsgreen\AutoTrader\Api\Enums;

class VehicleLookupFlags extends SharedFlags
{
    const
        // VehicleLookupFlags::MOT_TESTS
        // Provides most recent MOT test information for the specified vehicle.
        MOT_TESTS = 'motTests';
    const

        // VehicleLookupFlags::FEATURES
        // Provides an array of standard and possible optional features for the specified vehicle.
        FEATURES = 'features';
    const

        // VehicleLookupFlags::BASIC_VEHICLE_CHECK
        // Provides a variety of vehicle specific provenance data.
        BASIC_VEHICLE_CHECK = 'basicVehicleCheck';
    const

        // VehicleLookupFlags::FULL_VEHICLE_CHECK
        // Provides a variety of vehicle specific provenance data.
        FULL_VEHICLE_CHECK = 'fullVehicleCheck';
    const

        // VehicleLookupFlags::VALUATIONS
        // Provides a variety of Auto Trader valuations for the specified vehicle.
        VALUATIONS = 'valuations';
}
