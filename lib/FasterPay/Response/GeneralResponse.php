<?php

namespace FasterPay\Response;

use FasterPay\Exception;

class GeneralResponse extends Response
{
    public function __construct(array $response)
    {
        $this->validationResponse($response);
        $this->response = $response;
        $this->handleResult();
    }

    public function validationResponse(array $response)
    {
        if (!isset($response['response']) || !isset($response['httpCode'])) {
            throw new Exception('Invalid reponse format');
        }
    }

    public function handleResult()
    {
        $response = $this->getDecodeResponse();

        $httpCode = $this->getHttpCode();

        if ($httpCode != self::SUCCESS_CODE) {
            $errorMessage = empty($response['message']) ? self::RESPONSE_ERROR_TEXT : $response['message'];
            $this->errors = new ResponseError([
                'message' => $errorMessage, 'code' => $httpCode
            ]);
        }
    }

    public function isSuccessful()
    {
        return empty($this->errors);
    }

}
