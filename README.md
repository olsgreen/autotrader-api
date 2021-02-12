 # AutoTrader PHP API Client
[![Latest Version](https://img.shields.io/github/release/olsgreen/autotrader-api.svg?style=flat-square)](https://github.com/olsgreen/adobe-sign-api/releases)
[![Tests](https://github.com/olsgreen/autotrader-api/workflows/Tests/badge.svg)](https://github.com/olsgreen/autotrader-api/actions)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides a means easily of interacting with the AutoTrader API.

## Installation

Add the client to your project using composer.

    composer require olsgreen/autotrader-api

## Usage
AutoTrader require that you exchange your key & secret for an access token, this is then used to access the API.

### Get an access token

```php
// Create an instance of the client to obtain an access token.
$api = new \Olsgreen\AutoTrader\Client();
$accessToken = $api->authentication()->getAccessToken();

// once you have your access token you can create client instances like:
$api = new \Olsgreen\AutoTrader\Client(['access_token' => $accessToken]);
```

### Vehicles
This endpoint is used to look up UK registered vehicles and returns core vehicle data.

#### Lookup base information
Retrieves the vehicles base information data for a valid UK registration (VRM).

```php
$vehicle = $api->vehicles()->lookup('HG17XXX');

/*
 * Will return something similar to the below.
 * 
 * [
 *     "vehicle" => [
 *       "ownershipCondition" => "Used",
 *       "registration" => "HG17XXX",
 *       "vin" => "WMWWG320503CXXXXX",
 *       "make" => "MINI",
 *       "model" => "Convertible",
 *       "generation" => "Convertible (2015 - 2018)",
 *       "derivative" => "1.5 Cooper Convertible 2dr Petrol (s/s) (136 ps)",
 *       "derivativeId" => "5b746c3a24974b8fa1048b0141356a34",
 *       "vehicleType" => "Car",
 *       "trim" => "Cooper",
 *       "bodyType" => "Convertible",
 *       "fuelType" => "Petrol",
 *       "cabType" => null,
 *       "transmissionType" => "Manual",
 *       ...
 *       ],
 *     ],
 *   ]
 *
 * For the full response see:
 * https://developers.autotrader.co.uk/documentation#vehicle-base-information
 */
```

#### Extended lookups

You can retrieve extra datasets for a VRM via the `lookup` method by supplying the one or all of the following flags:

 - **VehicleLookupFlags::MOT_TESTS**
   
   Provides most recent MOT test information for the specified vehicle.
   

- **VehicleLookupFlags::FEATURES**

    Provides an array of standard and possible optional features for the specified vehicle.


- **VehicleLookupFlags::BASIC_VEHICLE_CHECK**

    Provides a variety of vehicle specific provenance data.


- **VehicleLookupFlags::FULL_VEHICLE_CHECK**

    Provides a variety of vehicle specific provenance data.


- **VehicleLookupFlags::VALUATIONS**

    Provides a variety of Auto Trader valuations for the specified vehicle.


- **VehicleLookupFlags::VEHICLE_METRICS**

    Provides a variety of Auto Trader valuations and vehicle metrics for the specified vehicle.


- **VehicleLookupFlags::COMPETITORS**

    Provides a pre-constructed URL, allowing users to explore market competition.

**Note:** The `VehicleLookupFlags::VEHICLE_METRICS` & `VehicleLookupFlags::VALUATIONS` flags also require the current mileage to be passed in as the last parameter as below.

```php
// For example, to retrieve the MOT & basic vehicle check datasets
// we can do the following:

$datasets = [
    VehicleLookupFlags::BASIC_VEHICLE_CHECK, 
    VehicleLookupFlags::VEHICLE_METRICS
];

$vehicle = $api->vehicles()->lookup('HG17XXX', $datasets, 35000);

/*
 * Will return something similar to the below.
 * 
 * [
 *     "vehicle" => [
 *       "ownershipCondition" => "Used",
 *       "registration" => "HG17XXX",
 *       "vin" => "WMWWG320503CXXXXX",
 *       "make" => "MINI",
 *       "model" => "Convertible",
 *       "generation" => "Convertible (2015 - 2018)",
 *       "derivative" => "1.5 Cooper Convertible 2dr Petrol (s/s) (136 ps)",
 *       "derivativeId" => "5b746c3a24974b8fa1048b0141356a34",
 *       "vehicleType" => "Car",
 *       "trim" => "Cooper",
 *       "bodyType" => "Convertible",
 *       "fuelType" => "Petrol",
 *       "cabType" => null,
 *       "transmissionType" => "Manual",
 *       ...
 * 
 *       "check" => [
 *           "insuranceWriteoffCategory" => null,
 *           "scrapped" => false,
 *           "stolen" => false,
 *           "imported" => false,
 *           "exported" => false,
 *           "previousOwners" => 1,
 *           "keeperChanges" => [
 *               [
 *                 "dateOfLastKeeper" => "2020-07-14",
 *               ],
 *           ],
 *           "v5cs" => [
 *               [
 *                 "issuedDate" => "2017-06-30",
 *               ],
 *           ],
 *       ],
 * 
 *      "motTests" => [
 *           [
 *               "completedDate" => "2020-06-26T10:05:59Z",
 *               "expiryDate" => "2021-06-25",
 *               "testResult" => "Passed",
 *               "odometerValue" => 16330,
 *               "odometerUnit" => "Miles",
 *               "motTestNumber" => "444811158817",
 *               "rfrAndComments" => [],
 *           ],
 *           ...
 *       ],
 *     ],
 *   ]
 *
 * For the full responses see:
 * https://developers.autotrader.co.uk/documentation#vehicle-base-information
 */
```