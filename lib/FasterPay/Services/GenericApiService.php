<?php
namespace FasterPay\Services;

use FasterPay\Exception;
use FasterPay\HttpClient;
use FasterPay\Response\GeneralResponse;

class GenericApiService
{
    // http methods
    const HTTP_METHOD_POST = 'post';
    const HTTP_METHOD_GET = 'get';
    const HTTP_METHOD_PUT = 'put';
    const HTTP_METHOD_DELETE = 'delete';

    protected $http;

    public function __construct(
        HttpClient $client
    ) {
        $this->http = $client;
    }

    public function call($endpoint, array $params = [], $method = self::HTTP_METHOD_POST, array $headers = [])
    {
        return new GeneralResponse($this->request($endpoint, $params, $method, $headers));
    }

    private function request($endpoint, array $params = [], $method = self::HTTP_METHOD_POST, array $headers = [])
    {
        $method = strtolower($method);

        if (!filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid endpoint format');
        }

        if (!in_array($method, $this->getAllowedHttpMethods())) {
            throw new Exception('Invalid http method');
        }

        return $this->http->{$method}($endpoint, $params, $headers);
    }

    protected function getAllowedHttpMethods()
    {
        return [
            self::HTTP_METHOD_POST,
            self::HTTP_METHOD_GET,
            self::HTTP_METHOD_PUT,
            self::HTTP_METHOD_DELETE
            
        ];
    }

}