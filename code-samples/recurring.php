<?php
require($_SERVER["DOCUMENT_ROOT"] . '/fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey'     => '<your-public-key>',
    'privateKey'    => '<your-private-key>',
    'isTest'        => 1
));

$form = $gateway->paymentForm()->buildForm(array(
    'description' => 'Test order',
		'amount' => '10',
		'currency' => 'USD',
		'merchant_order_id' => time(),
		'success_url' => 'https://yourcompanywebsite.com/success',
		'recurring_name' => 'recurring1',
		'recurring_sku_id' => 'recurring1',
		'recurring_period' => '6m',
		'recurring_trial_amount' => '30',
		'recurring_trial_period' => '1m',
    'pingback_url' => 'https://yourcompanywebsite.com/pingback'
), array("autoSubmitForm" => true));

echo $form;
