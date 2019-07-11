<?php

namespace FasterPay\Services;

use FasterPay\Gateway;

class PaymentForm
{

    const FORM_API_KEY_FIELD = 'api_key';
    const FORM_HASH_FIELD = 'hash';
    const FORM_ID = 'fasterpay_payment_form';
    const BUTTON_ID = 'fasterpay_submit';

    private $gateway;
    protected $endPoint = '/payment/form';

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function getEndPoint()
    {
        return $this->endPoint;
    }

    public function buildForm($parameters = [], $options = [])
    {
        $parameters = $this->prepareParameters($parameters);

        $form = '<form align="center" method="post" action="' . $this->gateway->getConfig()->getApiBaseUrl() . $this->getEndPoint() . '" name="' . self::FORM_ID . '" id="' . self::FORM_ID .'">';

        foreach ($parameters as $key => $val) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $val . '" class="field_' . $key . '"/>';
        }

        $form .= '<input type="Submit" value="Pay Now" id="' . self::BUTTON_ID .'"/></form>';

        $form = $this->customizeForm($form, $options);

        return $form;
    }

    protected function prepareParameters($params = [])
    {
        $params[self::FORM_API_KEY_FIELD] = $this->gateway->getConfig()->getPublicKey();

        $params[self::FORM_HASH_FIELD] = $this->gateway->signature()->calculateWidgetSignature($params);

        return $params;
    }

    protected function customizeForm($form, $options = [])
    {
        if (!empty($options['hidePayButton']) && $options['hidePayButton']) {
            $form .= '<script>document.getElementById("' . self::BUTTON_ID . '").style.display = "none";</script>';
        }

        if (!empty($options['autoSubmit']) && $options['autoSubmit']) {
            $form .= '<script>document.getElementById("' . self::FORM_ID. '").submit();</script>';
        }

        return $form;
    }
}
