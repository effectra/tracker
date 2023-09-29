# Effectra Tracker

Effectra Tracker is a PHP package that provides methods to extract information from the client's request, including IP address, browser details, operating system, device type, accepted languages, and referer URL. It also includes integration with IP tracking services to fetch additional attributes related to the provided IP address.

## Installation

You can install the Effectra Tracker package via [Composer](https://getcomposer.org/):

```bash
composer require effectra/tracker
```

## Usage

### Tracker Class

#### Initialize Tracker

```php
use Effectra\Tracker\Tracker;
use Psr\Http\Message\ServerRequestInterface;

$request = ...; // Your PSR-7 ServerRequestInterface implementation
$tracker = new Tracker($request);
```

#### Get Client's IP Address

```php
$ipAddress = $tracker->getIp();
```

#### Get Browser Details

```php
$browser = $tracker->getBrowser();
// $browser['name'] contains the browser name
// $browser['version'] contains the browser version
```

#### Get Operating System Details

```php
$os = $tracker->getOs();
// $os['name'] contains the OS name
// $os['version'] contains the OS version
```

#### Get Device Type

```php
$deviceType = $tracker->getDevice();
```

#### Get User Agent

```php
$userAgent = $tracker->getUserAgent();
```

#### Get Accepted Languages

```php
$acceptedLanguages = $tracker->getAcceptLangs();
```

#### Get Referer URL

```php
$refererUrl = $tracker->getReferer();
```

#### Check if Client is Using a Phone Device

```php
$isPhone = $tracker->isPhone();
```

#### Get All Client Information

```php
$clientInfo = $tracker->getAll();
// $clientInfo is an associative array containing all client information
```

### IP Tracking Services Integration

Effectra Tracker supports integration with various IP tracking services. Currently, the following services are supported:

#### IpGeoLocation Service

```php
use Effectra\Tracker\Services\IpGeoLocation;
use GuzzleHttp\Client;

$client = new Client(); // GuzzleHttp client instance
$ip = ...; // IP address to query
$apiKey = ...; // Your API key for ipgeolocation.io

$ipGeoLocation = new IpGeoLocation($client, $ip, $apiKey);
$ipAttributes = $ipGeoLocation->getAll();
```

#### IpRegistry Service

```php
use Effectra\Tracker\Services\IpRegistry;
use GuzzleHttp\Client;

$client = new Client(); // GuzzleHttp client instance
$ip = ...; // IP address to query
$apiKey = ...; // Your API key for ipregistry.co

$ipRegistry = new IpRegistry($client, $ip, $apiKey);
$ipAttributes = $ipRegistry->getAll();
```

#### IpWhoIs Service

```php
use Effectra\Tracker\Services\IpWhoIs;
use GuzzleHttp\Client;

$client = new Client(); // GuzzleHttp client instance
$ip = ...; // IP address to query

$ipWhoIs = new IpWhoIs($client, $ip, null); // No API key required for ipwho.is
$ipAttributes = $ipWhoIs->getAll();
```

## Requirements

- [PSR-7 HTTP Message](https://www.php-fig.org/psr/psr-7/)
- [Guzzle HTTP Client](https://docs.guzzlephp.org/en/stable/)
- [Effectra HTTP Foundation](https://github.com/effectra/http-foundation)

## Author

- **Mohammed Taha** - [Email](mailto:info@mohammedtaha.net)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.