<?php
require($_SERVER["DOCUMENT_ROOT"] . '/fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey'     => '<your-public-key>',
    'privateKey'    => '<your-private-key>',
    'isTest'        => 1
));

$cancel_response = $gateway->subscription()->cancel($_POST["order_id"]);

echo "<pre>";print_r($cancel_response);die;
