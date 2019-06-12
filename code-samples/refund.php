<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);

$orderId = '<your-order-id>';
$amount = '<refund-amount>';

try {
    $refundResponse = $gateway->paymentService()->refund($orderId, $amount);
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
