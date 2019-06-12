<?php
namespace FasterPay\Services;

use FasterPay\Gateway;

class Signature
{
    const SIGNATURE_ALGO = 'sha256';

    private $gateway = null;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function verify($string, $data)
    {
        if (empty($string) || empty($data)) {
            return false;
        }

        $calculateSign = $this->calculateSignature($data);

        return $calculateSign == $string;
    }

    public function calculateSignature($params = [])
    {
        ksort($params);

        return hash(self::SIGNATURE_ALGO, http_build_query($params) . $this->gateway->getConfig()->getPrivateKey());
    }

}