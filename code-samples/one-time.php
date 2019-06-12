<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);

$form = $gateway->paymentForm()->buildForm(
    [
        'description' => 'Test order',
        'amount' => '10',
        'currency' => 'USD',
        'merchant_order_id' => time(),
        'success_url' => 'https://yourcompanywebsite.com/success',
        'pingback_url' => 'https://yourcompanywebsite.com/pingback/'
    ],
    [
        'autoSubmit' => false,
        'hidePayButton' => false
    ]
);

echo $form;
