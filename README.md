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
            "access_token"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9eyJhdWQiOiIxIiwianRpIjoiNGM1ODQyMTMyNc",
            "expires_at"=> "2021-12-19T11:47:34.000000Z"
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
                "identifier=> "payments-cards",
                "name"=> "Payments Cards",
                "description"=> null,
                "logo"=> null,
                "banner"=> null,
                "has_sub"=> false
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
                "identifier"=> "free-fire",
                "name"=> "Free Fire",
                "description"=> "<p>Free Fire</p>",
                "logo"=> null,
                "banner"=> null,
                "has_sub"=> false
            ]
        ]
    */
    ```

### Wallet

- Balance

    ```php
    /**
     * Get use balance
     *
     * @return array
     */
    $balance = $payUse->getBalance();

    /*
        Response Example
        [
            "amount"=> 219982.7286,
            "formatted"=>"$219,982.73",
            "currency"=> "USD"
        ]
    */
    ```

### Products

- Get Products

    ```php
    /**
     * Get Products
     * 
     * @param string $categoryIdentifier
     * @param int $page
     * @param bool $paginate
     * 
     * @return array
     */
    $products = $payUse->getProducts("Mobile-Legends-Top-Up",1,true);

    /*
        Response Example
        [
            [
                "identifier"=> "Mobile-Legends-Top-Up-56",
                "name"=> "Mobile Legends Top Up 56",
                "description"=> "<p>Mobile Legends Top Up 56</p>",
                "category"=>[
                    "identifier"=> "Mobile-Legends-Top-Up",
                    "name"=> "Mobile Legends Top Up",
                    "description"=> "<p>Mobile Legends Top Up</p>",
                    "logo"=> null,
                    "banner"=> null,
                    "has_sub"=> false
                ],
                "type"=> "direct_top_up",
                "is_in_stock"=> true,
                "base_image"=> null,
                "price"=>[
                    "amount"=> 20,
                    "formatted"=> "$20.00",
                    "currency"=> "USD"
                ]
            ]
        ]
    */
    ```

### Verification

- Stock 

    ```php
    /**
     * Stock Verification
     * 
     * @param string $identifier
     * @param int $qty
     * 
     * @return bool
     */
    $available = $payUse->stockVerification("PUBG-Mobile-60-UC", 1)
    ```

### Purchase

- Create Voucher Order

    ```php
    /**
     * Create Voucher Order
     * 
     * @param string $identifier
     * @param int $qty
     * @param mixed $customOrderReference
     * @return array
    */
    $order = $payUse->createVoucherOrder("PUBG-Mobile-60-UC",  1, "ORDER-REF309873")

    /*
        Response Example
        [
            "orderReference" => "PU-ORDER00000000000070",
            "customOrderReference"=>"ORDER-REF309873",
            "lineTotal"=> [
                "amount"=> 10.1234,
                "formatted"=> "$10.12",
                "currency"=> "USD"
            ],
            "unitPrice"=> [
                "amount"=> 10.1234,
                "formatted"=> "$10.12",
                "currency"=> "USD"
            ],
            "codes"=> [
                [
                    "code"=> "162428192160d09341f0765",
                    "serial"=> "P079U-20791-15722-1EEB9-19A03"
                ]
            ]
        ]
    */
    ```

### Top Up
- Free Fire

    - Account Validation

        ```php
        /**
         * Free Fire Top up account validation
         * 
         * @param string $identifier
         * @param int $accountId
         * 
         * @return array
         */
        $validation = $payUse->freeFireAccountValidation(
            "Free-Fire-100-Plus-10-Diamonds-Top-Up", 
            "10000335"
        );

        /*
            Response Example
            [
                "account_id" => "10000335",
                "roles" => [[
                    "server_id" => 0,
                    "server" => "",
                    "role_id" => 0,
                    "client_type" => 0,
                    "role" => "JROMAN",
                    "packed_role_id" => 0
                ]]
            ]
        */
        ```

    - Top Up

        ```php
        /**
         * Free Fire Create Top Up 
         * 
         * @param string $identifier
         * @param int $accountId
         * @param int $packedRoleId
         * @param mixed $customOrderReference
         * 
         * @return array
         */
        $topUp = $payUse->freeFireTopUp(
            "Free-Fire-100-Plus-10-Diamonds-Top-Up",
            "10000335", 
            0,
            "ORDR-REF3098736");
        
        /*
            Response Example
            [
                "orderReference" => "PU-ORDER00000000000049",
                "customOrderReference" => "ORDR-REF3098736",
                "lineTotal" => [
                    "amount" => 3,
                    "formatted" => "$3.00",
                    "currency" => "USD",
                ],
                "unitPrice" => [
                    "amount" => 3,
                    "formatted" => "$3.00",
                    "currency" => "USD",
                ],
                "account_id" => "10000355"
            ]
        */
        ```
- Mobile Legends

    - Account Validation

        ```php
        /**
         * Mobile Legends Top up account validation
         * 
         * @param string $identifier
         * @param string $accountId
         * @param int $zoneId
         * 
         * @return array
         */
        $validation = $payUse->mobileLegendsAccountValidation(
            "Mobile-Legends-Top-Up-56", 
            "27295",
            "7000"
        );

        /*
            Response Example
            [
                "username" => "Test user",
                "account_id" => "27295",
                "customer_id" =>
                "cEAPMTA0NTExOTQwOTc4Mjk3AfnMAwKpz9UoQxZkaWFtb35kX21pbnRyb3V0
                ZVVTRF8xBJyqtvgFgA==",
                "flow_id" => "204511800978287"
            ]
        */
        ```

    - Top Up

        ```php
            /**
            * Mobile Legends Create Top Up 
            * 
            * @param string $identifier
            * @param int $accountId
            * @param string $customerId
            * @param string $flowId
            * @param mixed $customOrderReference
            * 
            * @return array
            */
            $topUp = $payUse->mobileLegendsTopUp(
                "Mobile-Legends-Top-Up-56",
                "27295",
                "cEAPMTA2OTY4OTE3Mjg1NzIwAdg2Ap/VAUMWZGlhbW9uZF9taW50cm91dGVVU0RfMQTRyKaKBoA=",
                "106968917285720", 
                "ORDER-REF102947"
            )

            /*
                Response Example
                [
                    "orderReference" => "PU-ORDER00000000000051",
                    "customOrderReference" => "ORDR-REF102947",
                    "lineTotal" => [
                        "amount" => 2,
                        "formatted" => "$2.00",
                        "currency" => "USD",
                    ],
                    "unitPrice" => [
                        "amount" => 2,
                        "formatted" => "$2.00",
                        "currency" => "USD",
                    ],
                    "account_id" => "27295"
                ]
            */
        ```
- Razer Gold
    - Account Validation

        ```php
            /**
            * Razer Gold Top up account validation
            * 
            * @param string $identifier
            * @param int $accountId
            * 
            * @return array
            */
            $validation = $payUse->razerGoldAccountValidation(
                "Razer-Gold-top-up",
                "razergoldsandbox+gl015@gmail.com"
            );

            /*
                Response Example
                [
                    "account_id"=> "razergoldsandbox+gl015@gmail.com",
                    "validated_token"=> "fc26c910d68543b3bc65e69c0a858f14",
                    "reference_id"=> "RG-d2be-42dd-8fa9-17e92fa72375-61499e99e14c9",
                    "wallet_balance"=> 165,
                    "wallet_currency_Code"=> "USD"
                ]
            */
        ```

    - Top Up

    ```php
        /**
        * Razer Gold Create Top Up 
        * 
        * @param string $identifier
        * @param int $accountId
        * @param string $validatedToken
        * @param string $referenceId
        * @param mixed $customOrderReference
        * 
        * @return array
        */
        $topUp = $payUse->razerGoldTopUp(
            "Razer-Gold-top-up",
            "razergoldsandbox+gl015@gmail.com",
            "fc26c910d68543b3bc65e69c0a858f14",
            "RG-d2be-42dd-8fa9-17e92fa72375-61499e99e14c9",
            "ORDER-REF038572"
        );

        /*
            Response Example
            [
                "orderReference" => "PU-ORDER00000000000050",
                "customOrderReference" => "ORDR-REF038572",
                "lineTotal" => [
                    "amount" => 2,
                    "formatted" => "$2.00",
                    "currency" => "USD",
                ],
                "unitPrice" => [
                    "amount" => 2,
                    "formatted" => "$2.00",
                    "currency" => "USD",
                ],
                "account_id" => "razergoldsandbox+gl005@gmail.com"
            ]
        */
    ```
### Orders
- Get Orders

    ```php
    /**
     * Get Orders
     * 
     * @param int $page
     * @param int $startDate
     *  - Unix timestamp
     * @param int $endDate
     *  - Unix timestamp
     * @param string $method 
     *  - api
     *  - bulk
     * @param string $productType
     *  - codes
     *  - direct_top_up
     * 
     * @return array
     */
     $orders = $payUser->getOrders(1);

    /*
        Response Example
        [
            [
                "order_number" => "PU-ORDER00000000000070",
                "order_tracking" => "PU-ORDER00000000000070",
                "sub_total" => [
                    "amount" => 10.1234,
                    "formatted" => "$10.12",
                    "currency" => "USD"
                ],
                "total" => [
                    "amount" => 10.1234,
                    "formatted" => "$10.12",
                    "currency" => "USD"
                ],
                "method" => "api",
                "product_type" => "codes",
                "status" => "finished",
                "products" => [
                    [
                        "identifier" => "Free-Fire-100-Plus-10-Diamonds",
                        "name" => "Free Fire 100 + 10 Diamonds",
                        "unit_price" => [
                            "amount" => 10.1234,
                            "formatted" => "$10.12",
                            "currency" => "USD"
                        ],
                        "line_total" => [
                            "amount" => 10.1234,
                            "formatted" => "$10.12",
                            "currency" => "USD"
                        ],
                        "qty" => 1,
                        "status" => "finished",
                        "codes" => [
                            [
                                "code" => "162428192160d09341f0765",
                                "serial" => "P079U-20791-15722-1EEB9-19A03"
                            ]
                        ]
                    ]
                ],
                "created_at" => "2021-12-19T11:52:34.000000Z"
            ]
        ]
    */

    ```

- Get Details Order
    ```php
    /**
     * Get Order details
     * 
     * @param mixed $orderNumber
     * @return array
    */
    $order = $payUse->getOrderDetails("PU-ORDER00000000000070");


    /*
        Response Example        
        [
            "order_number" => "PU-ORDER00000000000070",
            "order_tracking" => "PU-ORDER00000000000070",
            "sub_total" => [
                "amount" => 10.1234,
                "formatted" => "$10.12",
                "currency" => "USD"
            ],
            "total" => [
                "amount" => 10.1234,
                "formatted" => "$10.12",
                "currency" => "USD"
            ],
            "method" => "api",
            "product_type" => "codes",
            "status" => "finished",
            "products" => [
                [
                    "identifier" => "Free-Fire-100-Plus-10-Diamonds",
                    "name" => "Free Fire 100 + 10 Diamonds",
                    "unit_price" => [
                        "amount" => 10.1234,
                        "formatted" => "$10.12",
                        "currency" => "USD"
                    ],
                    "line_total" => [
                        "amount" => 10.1234,
                        "formatted" => "$10.12",
                        "currency" => "USD"
                    ],
                    "qty" => 1,
                    "status" => "finished",
                    "codes" => [
                        [
                            "code" => "162428192160d09341f0765",
                            "serial" => "P079U-20791-15722-1EEB9-19A03"
                        ]
                    ]
                ]
            ],
            "created_at" => "2021-12-19T11:52:34.000000Z"
        ]
        
    */
    ```

## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).