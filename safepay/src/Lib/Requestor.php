<?php

namespace Safepay\Lib;

use Safepay\Base;

class Requestor extends Base
{
    public function __construct() {}

    /**
     * Get the response from an API request securely.
     * @param  string $environment
     * @param  string $endpoint
     * @param  array  $params
     * @param  string $method
     * @return array
     */
    public static function send_request($environment = "sandbox", $endpoint = "", $params = array(), $method = 'GET')
    {
        $baseURL = $environment === self::SANDBOX ? self::SANDBOX_API_URL : self::PRODUCTION_API_URL;
        $url = $baseURL . $endpoint;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        // Dynamically extract the client authentication key if passed in the parameters
        $apiKey = isset($params['client']) ? $params['client'] : 'sec_1c973793-3e8e-4558-91a2-bce5818583f8';

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
            'Accept: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($environment === self::SANDBOX) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        if ($server_output === false) {
            $curl_error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL Network Failure: " . $curl_error);
        }

        curl_close($ch);
        $response = json_decode($server_output, true);

        if ($response === null || !is_array($response)) {
            echo "<h3 style='color:red;'>Raw Server Error Response from Safepay:</h3>";
            echo "<pre style='background:#f4f4f4; padding:15px; border:1px solid #ccc; max-width:100%; overflow:auto; white-space: pre-wrap;'>" . htmlspecialchars($server_output) . "</pre>";
            exit();
        }

        // If Safepay returns an explicit error payload, halt and show it immediately
        if (isset($response['error'])) {
            throw new \Exception("Safepay Gateway Error: " . $response['error']);
        }
        if (isset($response['message']) && !isset($response['token']) && !isset($response['data']['token'])) {
            throw new \Exception("Safepay Validation Error: " . $response['message']);
        }

        return $response;
    }
}
