<?php

namespace Prgayman\PayUse;

use Prgayman\PayUse\Traits\TopUp;
use Prgayman\PayUse\Traits\Voucher;
use Prgayman\PayUse\Utilities\Http;

require __DIR__ . '/init.php';

class PayUse
{

    use TopUp, Voucher;

    /**
     * Sandbox mode
     * 
     * @var string
     */
    public const MODE_SANDBOX = "sandbox";

    /**
     * Live mode
     * 
     * @var string
     */
    public const MODE_LIVE = "live";

    /**
     * Http request
     * 
     * @var Prgayman\PayUse\Utilities\Http;
     */
    protected $http;

    /**
     * Account email
     * 
     * @var string
     */
    private $email;

    /**
     * Account secret key
     * 
     * @var string
     */
    private $secretKey;

    public function __construct(string $mode, string $email, string $secretKey)
    {
        $this->http = new Http($mode);
        $this->email = $email;
        $this->secretKey = $secretKey;
    }

    /**
     * Set access token
     * 
     * @return void
     */
    private function setAccessToken(string $accessToken): void
    {
        $this->http->setAccessToken($accessToken);
    }

    /**
     * Sign In get access token
     * 
     * @param string $email
     * @param string $secret
     * 
     * @return array
     */
    public function signIn(): array
    {
        $signIn = $this->http->post("/v1/signin", [
            "email" => $this->email,
            "secret" => $this->secretKey
        ])['body'];

        // Set Access token
        $this->setAccessToken($signIn['access_token']);

        return $signIn;
    }

    /**
     * Get main categories
     * 
     * @param string $accessToken
     * 
     * @return array
     */
    public function getMainCategories(): array
    {
        return $this->http->get("/v1/categories")['body'];
    }

    /**
     * Get sub categories by identifier main category
     * 
     * @param string $identifier
     * 
     * @return array
     */
    public function getSubCategories(string $identifier): array
    {
        return $this->http->get("/v1/categories/sub", ["identifier" => $identifier])['body'];
    }

    /**
     * Get use balance
     *
     * @return array
     */
    public function getBalance(): array
    {
        return $this->http->get("/v1/wallet/balance")['body'];
    }

    /**
     * Get Products
     * 
     * @param string $categoryIdentifier
     * @param int $page
     * @param bool $paginate
     * 
     * @return array
     */
    public function getProducts(string $categoryIdentifier = null, int $page = 1, bool $paginate = false): array
    {
        return $this->http->get("/v1/products", [
            "page" => $page,
            'category_identifier' => $categoryIdentifier,
            'paginate' => $paginate ? "true" : "false"
        ])['body'];
    }

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
    public function getOrders(
        int $page = 1,
        string $method = null,
        string $productType = null,
        int $startDate = null,
        int $endDate = null
    ): array {
        return $this->http->get("/v1/orders", [
            "page" => $page,
            'method' => $method,
            'productType' => $productType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])['body'];
    }

    /**
     * Get Order details
     * 
     * @param mixed $orderNumber

     * @return array
     */
    public function getOrderDetails($orderNumber): array
    {
        return $this->http->get("/v1/orders/details", ['order_number' => $orderNumber])['body'];
    }
}
