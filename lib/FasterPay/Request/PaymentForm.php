<?php
namespace FasterPay\Request;

use FasterPay\Gateway;

class PaymentForm
{
	const END_POINT						= '/payment/form';
	const FORM_AMOUNT_FIELD 			= 'amount';
	const FORM_DESCRIPTION_FIELD 		= 'description';
	const FORM_CURRENCY_FIELD 			= 'currency';
	const FORM_API_KEY_FIELD			= 'api_key';
	const FORM_MERCHANT_ORDER_ID_FIELD	= 'merchant_order_id';
	const FORM_SUCCESS_URL				= 'success_url';
	const FORM_HASH_FIELD				= 'hash';

	const FORM_RECURRING_NAME_FIELD			= 'recurring_name';
	const FORM_RECURRING_SKU_ID_FIELD		= 'recurring_sku_id';
	const FORM_RECURRING_PERIOD_FIELD		= 'recurring_period';
	const FORM_RECURRING_TRIAL_AMOUNT_FIELD	= 'recurring_trial_amount';
	const FORM_RECURRING_TRIAL_PERIOD_FIELD = 'recurring_trial_period';

	private $gateway;

	public function __construct(Gateway $gateway)
	{
		$this->gateway = $gateway;
	}

	public static function getBasicPaymentFields()
	{
		return array(
			self::FORM_AMOUNT_FIELD,
			self::FORM_DESCRIPTION_FIELD,
			self::FORM_CURRENCY_FIELD,
			self::FORM_API_KEY_FIELD,
			self::FORM_MERCHANT_ORDER_ID_FIELD,
			self::FORM_SUCCESS_URL,
		);
	}

	public static function getSubscriptionPaymentFields()
	{
		return array(
			self::FORM_RECURRING_NAME_FIELD,
			self::FORM_RECURRING_SKU_ID_FIELD,
			self::FORM_RECURRING_PERIOD_FIELD
		);
	}

	public static function getSubscriptionTrialFields()
	{
		return array(
			self::FORM_RECURRING_TRIAL_AMOUNT_FIELD,
			self::FORM_RECURRING_TRIAL_PERIOD_FIELD
		);
	}	

	public function buildForm($parameters = array())
	{
		$parameters[self::FORM_API_KEY_FIELD]	= $this->gateway->getConfig()->getPublicKey();
		$parameters[self::FORM_HASH_FIELD] 	= $this->gateway->signature()->calculateHash($parameters);

        $form = '<form align="center" method="post" action="' . $this->gateway->getConfig()->getApiBaseUrl() . self::END_POINT .'">';
        foreach ($parameters as $key =>$val) {
            $form .= '<input type="hidden" name="'.$key.'" value="'.$val.'" />';
        }
        $form .= '<input type="Submit" value="Pay Now"/></form>';
        return $form;
    }
}