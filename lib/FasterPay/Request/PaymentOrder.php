<?php
namespace FasterPay\Request;

use FasterPay\Gateway;

class PaymentOrder
{
	const END_POINT						= '/payment/<order-id>/refund';

	private $gateway;

	public function __construct(Gateway $gateway)
	{
		$this->gateway = $gateway;
	}

  public function refund($orderId, $amount)
  {
    $url = str_replace("<order-id>", $orderId, $this->gateway->getConfig()->getApiBaseUrl() . self::END_POINT);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array("amount" => $amount));  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
		    'X-ApiKey: '. $this->gateway->getConfig()->getPrivateKey(),
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);

		curl_close ($ch);
		return json_decode($server_output, true);
  }
}
