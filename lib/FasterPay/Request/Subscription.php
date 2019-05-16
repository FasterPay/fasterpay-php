<?php
namespace FasterPay\Request;

use FasterPay\Gateway;

class Subscription
{
	const CANCEL_END_POINT						= '/api/subscription/<order-id>/cancel';

	private $gateway;

	public function __construct(Gateway $gateway)
	{
		$this->gateway = $gateway;
	}

	public function cancel($orderId){
		$url = str_replace("<order-id>", $orderId, $this->gateway->getConfig()->getApiBaseUrl() . self::CANCEL_END_POINT);

		$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array());  //Post Fields
		$headers = [
		    'X-ApiKey: '. $this->gateway->getConfig()->getPrivateKey(),
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$cancel_response = curl_exec ($ch);

		curl_close($ch);

		return json_decode($cancel_response);
	}
}
