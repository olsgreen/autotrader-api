<?php

namespace Olsgreen\AutoTrader\Api\Enums;

abstract class SharedFlags extends AbstractEnum
{
    const

        // VehicleLookupFlags::VEHICLE_METRICS
        // Provides a variety of Auto Trader valuations and vehicle metrics for the specified vehicle.
        VEHICLE_METRICS = 'vehicleMetrics';

    const

        // VehicleLookupFlags::COMPETITORS
        // Provides a pre-constructed URL, allowing users to explore market competition.
        COMPETITORS = 'competitors';
}
