<?php

require($_SERVER["DOCUMENT_ROOT"] . '/fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey'     => '<your-public-key>',
    'privateKey'    => '<your-private-key>',
    'isTest'        => 1
));

$refund_response = $gateway->paymentOrder()->refund($_POST["order_id"], $_POST["amount"]);

echo "<pre>"; print_r($refund_response);echo "</pre>";
