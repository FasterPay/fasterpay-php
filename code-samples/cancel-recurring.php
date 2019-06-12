<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);
$subscriptionId = '<your-subscription-id>';

try {
    $cancellationResponse = $gateway->subscriptionService()->cancel($subscriptionId);
} catch (FasterPay\Exception $e) {
    echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
    exit();
}

if ($cancellationResponse->isSuccessful()) {
    echo 'Canceled';
} else {
    echo $cancellationResponse->getErrors()->getMessage();
}