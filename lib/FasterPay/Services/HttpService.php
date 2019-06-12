<?php

namespace FasterPay\Services;

use FasterPay\Gateway;

class HttpService implements HttpServiceInterface
{
    protected $client;
    protected $endpoint;


    public function __construct(Gateway $client)
    {
        $this->client = $client;
    }

    public function getHttpClient()
    {
        return $this->client->getHttpClient();
    }

    public function getEndPoint($endpoint = '')
    {
        return $this->client->getEndPoint($endpoint);
    }

    public function __call($function, $params)
    {
        if (method_exists($this, $function)) {
            return call_user_func_array(array($this, $function), $params);
        }
    }
}
