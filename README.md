# Microsoft Graph Provider for Laravel Socialite

[![Latest Stable Version](https://poser.pugx.org/harrygulliford/socialite-microsoft-graph/v/stable)](https://packagist.org/packages/harrygulliford/socialite-microsoft-graph)
[![Total Downloads](https://poser.pugx.org/harrygulliford/socialite-microsoft-graph/downloads)](https://packagist.org/packages/harrygulliford/socialite-microsoft-graph)
[![License](https://poser.pugx.org/harrygulliford/socialite-microsoft-graph/license)](https://packagist.org/packages/harrygulliford/socialite-microsoft-graph)

This package extends Laravel Socialite to give a convenient method of authenticating via the Microsoft Graph OAuth2 provider.

Support for Laravel 6+ and Socialite 5+, using PHP 7.2+ & 8.0+.

## Installation

You can install the package via composer:

```bash
composer require harrygulliford/socialite-microsoft-graph
```

Then add the service to your `config/services.php` file:

```
'microsoft-graph' => [
    'client_id' => env('MS_GRAPH_KEY'),
    'client_secret' => env('MS_GRAPH_SECRET'),
    'tenant_id' => env('MS_GRAPH_TENANT_ID', 'common'),
    'redirect' => env('MS_GRAPH_REDIRECT_URL'),
],
```

## Usage

You are able to use the provider in the same manner as a regular Socialite provider.

```php
return Socialite::with('microsoft-graph')->redirect();
```

For more information, please refer to the [Laravel Socialite documentation](https://laravel.com/docs/6.0/socialite).

## License

The MIT License (MIT). Please see the [license file](LICENSE.md) for more information.
