<?php

namespace Prgayman\PayUse\Traits;

trait Voucher
{

    /**
     * Create Voucher Order
     * 
     * @param string $identifier
     * @param int $qty
     * @param mixed $customOrderReference

     * @return array
     */
    public function  createVoucherOrder(string $identifier, int $qty = 1, $customOrderReference = null): array
    {
        return $this->http->post("/v1/purchase/createOrder", [
            'identifier' => $identifier,
            'qty' => $qty,
            'customOrderReference' => $customOrderReference,
        ])['body'];
    }

    /**
     * Stock Verification
     * 
     * @param string $identifier
     * @param int $page
     * 
     * @return bool
     */
    public function stockVerification(string $identifier, int $qty = 1): bool
    {
        return $this->http->post("/v1/verification/stock", [
            "identifier" => $identifier,
            'qty' => $qty,
        ])['body']['available'];
    }
}
