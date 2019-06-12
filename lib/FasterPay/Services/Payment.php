<?php
namespace FasterPay\Services;

use FasterPay\Exception;
use FasterPay\Response\PaymentResponse;

class Payment extends GeneralService
{
    protected $endpoint = 'payment';

    public function refund($orderId = 0, $amount = 0)
    {
        if (!($orderId)) {
            throw new Exception('Missing Order Id');
        }

        if ($amount < 0) {
            throw new Exception('Amount must greater than 0');
        }

        $endpoint = $this->httpService->getEndPoint($this->endpoint . '/' . $orderId . '/refund');
        $params = array('amount' => $amount);

        $response = $this->httpService->getHttpClient()->post($endpoint, $params);

        return new PaymentResponse($response);
    }

}
