# PayUse Api


## Introduction
Php package a helper to integration with payuse api

## Installation

To get the latest version of payuse-php on your project, require it from "composer":

    $ composer require prgayman/payuse-php

Or you can add it directly in your composer.json file:

```json
{
  "require": {
    "prgayman/payuse-php": "1.0.0"
  }
}
```

## Environments
- Live ```Prgayman\PayUse\PayUse::MODE_LIVE```
- Sandbox ```Prgayman\PayUse\PayUse::MODE_SANDBOX```
    
## Exceptions
 - ```Prgayman\PayUse\Exceptions\PayUseException```


## Usage

```php
use Prgayman\PayUse\PayUse;

$email = "yourEmail@example.com";
$secretKey = "YourSecretKey";

/**
 * PayUse
 * 
 * @param string $mode
 * @param string $email
 * @param string #secretKey
 **/
$payUse = new PayUse(
    PayUse::MODE_SANDBOX,
    $email,
    $secretKey
);
```

## Authentication
### Sign-In

Use function to get access token

```php
/**
 * Sign In get access token
 * 
 * @return array
 */
$signIn = $payUse->signIn();

```

## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).