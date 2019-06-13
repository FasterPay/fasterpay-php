<?php

namespace FasterPay\Response;

class PaymentResponse extends Response
{

    public function handleResult()
    {
        $response = $this->getDecodeResponse();

        $httpCode = $this->getHttpCode();

        if ($httpCode != self::SUCCESS_CODE) {
            $errorMessage = empty($response['message']) ? self::RESPONSE_ERROR_TEXT : $response['message'];
            $this->errors = new ResponseError(array('message' => $errorMessage, 'code' => $httpCode));
        } else {
            $this->success = true;
        }
    }

}
