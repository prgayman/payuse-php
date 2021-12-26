<?php

namespace Prgayman\PayUse\Traits;

trait TopUp
{
    /**
     *  Net Dragon (Eudemons Online, Conquer Online & Heroes Evolved) Account initialization
     * 
     * @param string $identifier
     * 
     * @return array
     */
    public function netDragonAccountInitialization(string $identifier): array
    {
        return $this->accountInitialization($identifier);
    }

    /**
     *  Net Dragon (Eudemons Online, Conquer Online & Heroes Evolved) account validation
     * 
     * @param string $identifier
     * @param string $accountId
     * @param string $serverId
     * 
     * @return array
     */
    public function netDragonAccountAccountValidation(string $identifier, string $accountId, string $serverId): array
    {
        return $this->accountValidation($identifier, $accountId, [
            "server_id" => $serverId
        ]);
    }

    /**
     * Net Dragon (Eudemons Online, Conquer Online & Heroes Evolved) Create Top Up 
     * 
     * @param string $identifier
     * @param string $accountId
     * @param string $serverId
     * @param mixed $customOrderReference
     * 
     * @return array
     */
    public function netDragonTopUp(string $identifier, string $accountId, string $serverId, $customOrderReference = null): array
    {
        return $this->createTopUp($identifier, $accountId, $customOrderReference, ['server_id' => $serverId]);
    }

    /**
     * Free Fire Top up account validation
     * 
     * @param string $identifier
     * @param int $accountId
     * 
     * @return array
     */
    public function freeFireAccountValidation(string $identifier, int $accountId): array
    {
        return $this->accountValidation($identifier, $accountId);
    }

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
    public function freeFireTopUp(string $identifier, int $accountId, int $packedRoleId, $customOrderReference = null): array
    {
        return $this->createTopUp($identifier, $accountId, $customOrderReference, ['packed_role_id' => $packedRoleId]);
    }

    /**
     * Mobile Legends Top up account validation
     * 
     * @param string $identifier
     * @param string $accountId
     * @param int $zoneId
     * 
     * @return array
     */
    public function mobileLegendsAccountValidation(string $identifier, int $accountId, int $zoneId): array
    {
        return $this->accountValidation($identifier, $accountId, ['zone_id' => $zoneId]);
    }

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
    public function mobileLegendsTopUp(string $identifier, int $accountId, string $customerId, string $flowId, $customOrderReference = null): array
    {
        return $this->createTopUp($identifier, $accountId, $customOrderReference, ['flow_id' => $flowId, 'customer_id' => $customerId]);
    }

    /**
     * Razer Gold Top up account validation
     * 
     * @param string $identifier
     * @param int $accountId
     * 
     * @return array
     */
    public function razerGoldAccountValidation(string $identifier, string $accountId): array
    {
        return $this->accountValidation($identifier, $accountId);
    }

    /**
     * Razer Gold Create Top Up 
     * 
     * @param string $identifier
     * @param string $accountId
     * @param string $validatedToken
     * @param string $referenceId
     * @param mixed $customOrderReference
     * 
     * @return array
     */
    public function razerGoldTopUp(string $identifier, string $accountId, string $validatedToken, string $referenceId, $customOrderReference = null): array
    {
        return $this->createTopUp($identifier, $accountId, $customOrderReference, ['validated_token' => $validatedToken, 'reference_id' => $referenceId]);
    }

    /**
     * Top up account Initialization
     * 
     * @param string $identifier
     * 
     * @return array
     */
    private function accountInitialization(string $identifier): array
    {
        return $this->http->post("/v1/top-up/account-initialization", [
            'identifier' => $identifier,
        ])['body'];
    }

    /**
     * Top up account validation
     * 
     * @param string $identifier
     * @param mixed $accountId
     * 
     * @return array
     */
    private function accountValidation(string $identifier, $accountId, $extraData = []): array
    {
        return $this->http->post("/v1/top-up/validation", array_merge([
            'identifier' => $identifier,
            'account_id' => $accountId,
        ], $extraData))['body'];
    }

    /**
     * Top up account validation
     * 
     * @param string $identifier
     * @param mixed $accountId
     * @param mixed $customOrderReference
     * 
     * @return array
     */
    private function createTopUp(string $identifier, $accountId, $customOrderReference = null, $extraData = []): array
    {
        return $this->http->post("/v1/top-up/createOrder", array_merge([
            'identifier' => $identifier,
            'account_id' => $accountId,
            "customOrderReference" => $customOrderReference
        ], $extraData))['body'];
    }
}
