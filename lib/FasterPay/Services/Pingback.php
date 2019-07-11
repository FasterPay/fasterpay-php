<?php
namespace FasterPay\Services;

use FasterPay\Gateway;

class Pingback
{
    const EXPIRED_TIME_V2 = 300;

    private $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function validate($params = [])
    {
        $version = Signature::SIGN_VERSION_1;

        if (!empty($params['signVersion'])) {
            $version = $params['signVersion'];
        }

        switch ($version) {
            case Signature::SIGN_VERSION_1:
                return $this->validateV1($params);
            case Signature::SIGN_VERSION_2:
                return $this->validateV2($params);
        }

        return false;

    }

    public function validateV1($params) {
        if (empty($params)) {
            return false;
        }

        if (!array_key_exists('apiKey', $params)) {
            return false;
        }

        return $params['apiKey'] === $this->gateway->getConfig()->getPrivateKey();
    }

    public function validateV2($params)
    {

        if (empty($params['pingbackData']) || empty($params['signVersion']) || empty($params['signature'])) {
            return false;
        }

        $pingbackData = json_decode($params['pingbackData'], 1);
        $timestamp = !empty($pingbackData['pingback_ts']) ? $pingbackData['pingback_ts'] : 0;
        if ((time() - $timestamp) > self::EXPIRED_TIME_V2) {
            return false;
        }

        $expectedSignature = $this->gateway->signature()->calculatePingbackSignature($params['pingbackData'], $params['signVersion']);
        return hash_equals($expectedSignature, $params['signature']);
    }
}