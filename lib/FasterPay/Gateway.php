<?php
namespace FasterPay;

use FasterPay\Request\PaymentForm;
use FasterPay\Validator\Signature;
use FasterPay\Validator\Pingback;

class Gateway 
{

	private $config = null;

	public function __construct($config = array())
	{
		if (is_array($config)) {
			$config = new Config($config);
		}

		$this->config = $config;
	}

	public function paymentForm()
	{
		return new PaymentForm($this);
	}

	public function signature()
	{
		return new Signature($this);
	}

	public function pingback()
	{
		return new Pingback($this);
	}

	public function getConfig()
	{
		return $this->config;
	}

}
