<?php
namespace FasterPay;

class Config
{

	const VERSION = '1.0.0';
	const API_BASE_URL = 'https://pay.fasterpay.com';
	const API_SANDBOX_BASE_URL = 'https://pay.sandbox.fasterpay.com';

	private $publicKey 	= null;
	private $privateKey = null;
	private $apiBaseUrl = self::API_BASE_URL;
	private $isTest		= 0;

	public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if ($key == 'publicKey') {
                $this->publicKey = $value;
            }

            if ($key == 'privateKey') {
                $this->privateKey = $value;
            }

            if ($key == 'apiBaseUrl') {
                $this->apiBaseUrl = $value;
            }

            if ($key == 'isTest' && $value) {
            	$this->isTest = 1;
            	$this->apiBaseUrl = self::API_SANDBOX_BASE_URL;
            }
        }
    }

	public function getVersion()
	{
		return self::VERSION;
	}

	public function setPrivateKey($key)
	{
		$this->privateKey = $key;
	}

	public function getPrivateKey()
	{
		return $this->privateKey;
	}

	public function setPublicKey($key)
	{
		$this->publicKey = $key;
	}

	public function getPublicKey()
	{
		return $this->publicKey;
	}

	public function getApiBaseUrl()
	{
		return $this->apiBaseUrl;
	}

	public function setBaseUrl($url)
	{
		$this->apiBaseUrl = $url;
	}

	public function getIsTest()
	{
		return $this->isTest;
	}

	public function setIsTest($value)
	{
		if ($value) {
			$this->isTest = 1;
		} else {
			$this->isTest = 0;
		}
	}

}