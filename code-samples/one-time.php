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
  'pingback_url' => 'https://yourcompanywebsite.com/pingback.php'
), array("autoSubmitForm" => false));

echo $form;
