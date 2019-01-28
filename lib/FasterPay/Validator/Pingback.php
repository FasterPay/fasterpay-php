<?php
namespace FasterPay\Validator;

use FasterPay\Gateway;

class Pingback
{
	private $gateway;

	public function __construct(Gateway $gateway)
	{
		$this->gateway = $gateway;
	}

	public function validate($params = array())
	{
		if (empty($params)) {
			return false;
		}

		if (!array_key_exists('apiKey', $params)) {
			return false;
		}

		if ($params['apiKey'] === $this->gateway->getConfig()->getPrivateKey()) {
			return true;
		}

		return false;
	}
}