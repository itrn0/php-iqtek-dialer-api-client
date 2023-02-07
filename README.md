# php-iqtek-dialer-api-client

A PHP library for interacting with IQTek's Dialer API.

## Installation

To install the library, simply use composer:

```
composer require itrn0/php-iqtek-dialer-api-client
```

## Usage

```php
use Itrn0\Iqtek\Dialer\Api\Client;

$client = new Client([
  'api_key' => 'API_KEY',
]);
// or 
$client = new Client([]);
$client->login('USERNAME', 'PASSWORD');

$lead = $client->getLead('ID');
```

## License

This library is released under the MIT License. 