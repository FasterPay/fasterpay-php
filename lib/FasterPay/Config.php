<?php
namespace FasterPay;

class Config
{

	const VERSION = '1.0.0';
	const API_BASE_URL = 'https//pay.fasterpay.com';

	public static $instance;

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

}