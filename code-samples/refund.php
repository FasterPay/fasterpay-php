<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey' => 'a7b7fe9a2ca2c717720577b5243a565d',
    'privateKey' => '69d7686cf2fe45d4f12c207d9c4b9845',
    'isTest' => 0,
    'apiBaseUrl' => 'http://develop.pay2.fasterpay.bamboo.stuffio.com'
));

try {
    $refundResponse = $gateway->paymentService()->refund(12735, 1);
} catch (FasterPay\Exception $e) {
    echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
    exit();
}

echo '<pre>';
print_r($refundResponse);
echo '</pre>';

var_dump($refundResponse->isSuccessful());
