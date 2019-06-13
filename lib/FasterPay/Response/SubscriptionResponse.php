<?php

namespace FasterPay\Response;

class SubscriptionResponse extends Response
{

    public function handleResult()
    {
        $response = $this->getDecodeResponse();

        if (!empty($response['success']) && $response['success']) {
            $this->success = true;
        } elseif (!empty($response['type']) && $response['type'] == self::RESPONSE_ERROR_TEXT) {
            $errorMessage = empty($response['message']) ? 'Error' : $response['message'];
            $code = empty($response['code']) ? self::DEFAULT_ERROR_CODE : $response['code'];
            $this->errors = new ResponseError(array('message' => $errorMessage, 'code' => $code));
        }
    }

}
