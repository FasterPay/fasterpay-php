<?php
namespace FasterPay\Validator;

use FasterPay\Gateway;

class Signature
{
	private $gateway = null;

	public function __construct(Gateway $gateway)
	{
		$this->gateway = $gateway;
	}

	public function calculateHash($params = array())
	{
		ksort($params);
		return hash('sha256', http_build_query($params) . $this->gateway->getConfig()->getPrivateKey());
	}

}