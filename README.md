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

### Authentication
- Sign-In
    ```php
    /**
     * Sign In get access token and automatically to set access token to header request
     * 
     * @return array
     */
    $signIn = $payUse->signIn();

    /*
        Response Example
        [
            "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9eyJhdWQiOiIxIiwianRpIjoiNGM1ODQyMTMyNc",
            "expires_at": "2021-12-19T11:47:34.000000Z"
        ]
    */
    ```

### Categories

- Main Categories

    ```php
    /**
     * Get main categories
     * 
     * @return array
     */
    $categories = $payUse->getMainCategories():
    
    /*
        Response Example
        [
            [
                "identifier": "payments-cards",
                "name": "Payments Cards",
                "description": null,
                "logo": null,
                "banner": null,
                "has_sub": false
            ]
        ]
    */
    ```
- Sub Categories

    ```php
    /**
     * Get sub categories by identifier main category
     * 
     * @param string $identifier
     * 
     * @return array
     */
    $categories = $payUse->getSubCategories("top-up"):
    
    /*
        Response Example
        [
            [
                "identifier": "free-fire",
                "name": "Free Fire",
                "description": "<p>Free Fire</p>",
                "logo": null,
                "banner": null,
                "has_sub": false
            ]
        ]
    */
    ```
## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).