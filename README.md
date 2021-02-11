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
// Create an instance of the client.
$api = new \Olsgreen\AutoTrader\Client();
$accessToken = $api->authentication()->getAccessToken()
```
