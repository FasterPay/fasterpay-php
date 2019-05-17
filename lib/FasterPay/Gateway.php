lib/FasterPay/Gateway.php<?php
namespace FasterPay;

use FasterPay\Request\PaymentForm;
use FasterPay\Request\PaymentOrder;
use FasterPay\Request\Subscription;
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

	public function paymentOrder()
	{
		return new PaymentOrder($this);
	}

	public function subscription()
	{
		return new Subscription($this);
	}

	public function getConfig()
	{
		return $this->config;
	}

}
