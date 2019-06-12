<?php

namespace FasterPay;

class Response
{
    const SUCCESS_CODE = 200;

    protected $response;
    protected $errors;
    protected $success = false;

    public function __construct($response)
    {
        $this->response = $response;

        $response = $this->getDecodeResponse();

        $httpCode = $this->getHttpCode();

        if ($httpCode != self::SUCCESS_CODE) {
            $errorMessage = empty($response['message']) ? 'Error' : $response['message'];
            $this->errors = new ResponseError(array('message' => $errorMessage, 'code' => $httpCode));
        } else {
            $this->success = true;
        }
    }

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
