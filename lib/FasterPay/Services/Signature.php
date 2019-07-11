<?php
namespace FasterPay\Services;

use FasterPay\Gateway;

class Signature
{
    const SIGNATURE_ALGO = 'sha256';
    const SIGN_VERSION_1 = 'v1';
    const SIGN_VERSION_2 = 'v2';
    const SIGN_VERSION_1_CODE = 1;
    const SIGN_VERSION_2_CODE = 2;

    private $gateway = null;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function calculateWidgetSignature($parameters) {
        $version = null;

        if (!empty($parameters['sign_version']) && ($parameters['sign_version'] == self::SIGN_VERSION_2)) {
            $version = self::SIGN_VERSION_2;
        }

        $this->ksortParameters($parameters, $version);

        $baseString = $this->getEncodedString($parameters, $version);

        if ($version == self::SIGN_VERSION_2) {
            return hash_hmac('sha256', $baseString, $this->gateway->getConfig()->getPrivateKey());
        }

        return hash('sha256', $baseString . $this->gateway->getConfig()->getPrivateKey());
    }

    public function getEncodedString($parameters, $version = self::SIGN_VERSION_1)
    {
        if ($version == self::SIGN_VERSION_2) {
            $encodeString = '';
            foreach ($parameters as $k => $v) {
                if (is_array($v)) {
                    $encodeString .= $this->getEncodedString($v, $version);
                    continue;
                }

                $encodeString .= "$k=$v;";
            }

            return $encodeString;
        }

        return http_build_query($parameters);
    }

    public function ksortParameters(&$parameters, $version = self::SIGN_VERSION_1)
    {
        if ($version == self::SIGN_VERSION_2) {
            ksort($parameters);
            foreach($parameters as $k => $v) {
                if (!is_array($v)) {
                    continue;
                }

                $this->ksortParameters($parameters[$k], $version);
            }

            return;
        }

        ksort($parameters);
    }

    public function calculatePingbackSignature($pingbackData = null, $version = self::SIGN_VERSION_1)
    {
        if ($version == self::SIGN_VERSION_2) {
            return hash_hmac('sha256' , $pingbackData, $this->gateway->getConfig()->getPrivateKey());
        }

        return null;
    }
}