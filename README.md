# Bridger Insight XG PHP Client (SOAP-first)

A Composer package scaffold for integrating with **LexisNexis Bridger Insight XG**.
It ships with:

- WSDL-driven SOAP generation via `phpro/soap-client`
- WS-Security UsernameToken injection (ClientId + UserId + Password)
- A runtime SoapClient wrapper for quick exploration
- A high-level `SecurityChecksRunner` to orchestrate multiple screening passes
- Laravel Service Provider and Facade
- Example usage and PHPUnit test stubs

> You must provide your tenant-specific **WSDL URL** and **staging/production credentials**.

## Install

```bash
composer require triplenerdscore/bridger-insight
```

## Configure

Set env vars (or publish config in Laravel):

```
BRIDGER_WSDL=https://<tenant>/LN.WebServices/11.2/XGServices.svc?singleWsdl
BRIDGER_CLIENT_ID=your-client-id
BRIDGER_USER_ID=your-user-id
BRIDGER_PASSWORD=your-password
BRIDGER_TIMEOUT=15
BRIDGER_CACHE_WSDL=1
```

## Generate SOAP Types and Client

This package is WSDL-agnostic until you generate code:

```bash
# Ensure dependencies installed
composer install

# Set WSDL (env or argument) and run generator
BRIDGER_WSDL="https://<tenant>/XGServices.svc?singleWsdl" bin/bridger-generate
```

This creates PHP classes under `src/Soap/Generated` with a client like `XgServicesClient` and request/response types.

## Quick Example

```php
use Tns\BridgerInsight\BridgerInsight;
use Tns\BridgerInsight\Dto\ScreeningRequest;

$bi = BridgerInsight::fromEnv();

$req = (new ScreeningRequest())
    ->person()
    ->name(given: 'Jane', surname: 'Doe')
    ->dob('1985-02-10')
    ->address(line1: '1 Main St', city: 'Boston', postalCode: '02108', countryCode: 'US');

// Single pass search
$response = $bi->screening()->searchPerson($req);

// Or run all configured security profiles
$full = $bi->securityChecks()->runAll($req);
```

## Laravel

```bash
php artisan vendor:publish --tag=bridger-config
```

Then configure `config/bridger-insight.php` and use the Facade:

```php
use BridgerInsight;

$response = BridgerInsight::screening()->searchPerson($req);
```

## Notes

- Logging avoids PII by default. Enable redacted logging if needed.
- Retries are applied for timeouts/5xx. Validation faults are not retried.
- If your contract enables REST, add an adapter under `src/Rest` and wire it through `Contracts\ScreeningClient`.

## Testing

Add your test credentials to `.env.testing` and run:

```bash
vendor/bin/phpunit
```
