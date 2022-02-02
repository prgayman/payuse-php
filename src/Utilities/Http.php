<?php

namespace Prgayman\PayUse\Utilities;

use Prgayman\PayUse\Exceptions\PayUseException;

class Http
{

    /**
     * Base Url
     * 
     * @var string
     */
    private $baseUrl = "";

    /**
     * Access token
     * 
     * @var string
     */
    private $accessToken;

    public function __construct(string $mode)
    {
        $this->baseUrl = $mode == "live" ? LIVE_URL : SANDBOX_URL;
    }

    /**
     * Set access token
     * 
     * @return void
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get headers
     * 
     * @param array $headers
     * 
     * @return array
     */
    private  function headers($headers = []): array
    {
        $defaultHeaders = [
            "Accept: application/json",
            "X-Payuse-Locale: en",
        ];

        if ($this->accessToken) {
            $defaultHeaders[] = "Authorization: Bearer {$this->accessToken}";
        }

        foreach ($headers as $key => $value) {
            $defaultHeaders[] = "{$key}: {$value}";
        }
        return $defaultHeaders;
    }

    /**
     * Http request post method
     * 
     * @param string $uri
     * @param array $params
     * @param array $headers
     * 
     * @return array
     */
    public function post(string $uri, array $params = [], array $headers = []): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "{$this->baseUrl}{$uri}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers($headers));
        if (count($params) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error    = \curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($this->successful($statusCode)) {
            return json_decode($response, true) ?? [];
        } elseif ($statusCode != 0) {
            $error = json_decode($response, true)["message"] ?? $response;
        }

        throw new PayUseException($error);
    }

    /**
     * Http request get method
     * 
     * @param string $uri
     * @param array $params
     * @param array $headers
     * 
     * @return array
     */
    public  function get(string $uri, array $params = [], array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->baseUrl}{$uri}?" . http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers($headers));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error    = \curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($this->successful($statusCode)) {
            return json_decode($response, true) ?? [];
        }

        throw new PayUseException($statusCode == 0 ? $error :  $response);
    }

    /**
     * Determine if the response indicates a client or server error occurred.
     *
     * @return bool
     */
    public function failed($status)
    {
        return $this->serverError($status) || $this->clientError($status);
    }

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function successful($status)
    {
        return $status >= 200 && $status < 300;
    }

    /**
     * Determine if the response indicates a client error occurred.
     *
     * @return bool
     */
    public function clientError($status)
    {
        return $status >= 400 && $status < 500;
    }

    /**
     * Determine if the response indicates a server error occurred.
     *
     * @return bool
     */
    public function serverError($status)
    {
        return $status >= 500;
    }
}
