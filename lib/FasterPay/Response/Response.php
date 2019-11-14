<?php

namespace FasterPay\Response;

abstract class Response
{
    const SUCCESS_CODE = 200;
    const RESPONSE_ERROR_TEXT = 'error';
    const DEFAULT_ERROR_CODE = 400;

    protected $response;
    protected $errors;
    protected $success = false;

    public function __construct($response)
    {
        $this->response = $response;

        $this->handleResult();
    }

    public abstract function handleResult();

    public function getRawResponse()
    {
        return $this->response['response'];
    }

    public function getDecodeResponse()
    {
        return json_decode($this->getRawResponse(), true);
    }

    public function getHttpCode()
    {
        return $this->response['httpCode'];
    }

    public function getResponse($key = '')
    {
        $decodeResponse = $this->getDecodeResponse();

        return $key ? (isset($decodeResponse[$key]) ? $decodeResponse[$key] : null) : $decodeResponse;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isSuccessful()
    {
        return $this->success;
    }
}

class ResponseError
{

    protected $message;
    protected $code;

    public function __construct(array $errors)
    {
        $this->message = $errors['message'];
        $this->code = $errors['code'];
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCode()
    {
        return $this->code;
    }
}
