<?php
namespace FasterPay\Services;

use FasterPay\Exception;
use FasterPay\Response\SubscriptionResponse;

class Subscription extends GeneralService
{
    protected $endpoint = 'api/subscription';

    public function cancel($subscriptionId)
    {
        if (empty($subscriptionId)) {
            throw new Exception('Subscription Id is null');
        }

        $endpoint = $this->httpService->getEndPoint($this->endpoint . '/' . $subscriptionId . '/cancel');

        $response = $this->httpService->getHttpClient()->post($endpoint);

        return new SubscriptionResponse($response);

    }


}
