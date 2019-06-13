<?php

namespace FasterPay;

class HttpClient
{
    protected $header;

    public function __construct(array $header = [])
    {
        $this->header = $header;
    }

    public function init()
    {
        $ch = curl_init();

        $defaultOptions = [
            CURLOPT_USERAGENT => 'FasterPay-PHP-SDK',
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 60,
        ];

        curl_setopt_array($ch, $defaultOptions);

        return $ch;
    }

    public function get($endpoint, array $params = [], array $headers = [])
    {
        return $this->call($endpoint, $params, 'GET', $headers);
    }

    public function post($endpoint, array $params = [], array $headers = [])
    {
        return $this->call($endpoint, $params, 'POST', $headers);
    }

    public function put($endpoint, array $params = [], array $headers = [])
    {
        return $this->call($endpoint, $params, 'PUT', $headers);
    }

    public function delete($endpoint, array $params = [], array $headers = [])
    {
        return $this->call($endpoint, $params, 'DELETE', $headers);
    }


    private function call($endpoint, array $params = [], $method, array $headers = [])
    {
        $ch = $this->init();

        $header = array_merge($this->header, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        switch (strtoupper($method)) {
            case 'POST':
                if (!empty($params)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                }
            case 'PUT':
            case 'DELETE':
                curl_setopt($ch, CURLOPT_HTTPGET, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                break;
            case 'GET':
                if (!empty($params)) {
                    $endpoint .= '?' . http_build_query($params);
                }

                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
        }

        curl_setopt($ch, CURLOPT_URL, $endpoint);


        $response = curl_exec($ch);


        $info = curl_getinfo($ch);
        curl_close($ch);

        return array(
            'response' => $response,
            'httpCode' => $info['http_code']
        );
    }

}
