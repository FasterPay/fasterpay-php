<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey' => 'a7b7fe9a2ca2c717720577b5243a565d',
    'privateKey' => '69d7686cf2fe45d4f12c207d9c4b9845',
    'isTest' => 0,
    'apiBaseUrl' => 'http://develop.pay2.fasterpay.bamboo.stuffio.com'
));

$form = $gateway->paymentForm()->buildForm(
    array(
        'description' => 'Test order',
        'amount' => '10',
        'currency' => 'USD',
        'merchant_order_id' => time(),
        'success_url' => 'https://yourcompanywebsite.com/success',
        'pingback_url' => 'http://testbed1.stuffio.com/pingback/'
    ),
    array(
        'autoSubmit' => false,
        'hidePayButton' => false
    )
);

echo $form;
