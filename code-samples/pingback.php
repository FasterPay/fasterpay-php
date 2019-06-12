<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);

$pingbackData = $_REQUEST;

if (!empty($pingbackData)) {

    if ($gateway->pingback()->validate(
        ["apiKey" => $_SERVER["HTTP_X_APIKEY"]])
    ) {
        echo "<pre>";
        print_r($pingbackData);
        echo '</pre>';
        #TODO: Write your code to deliver contents to the End-User.
        echo "OK";
        exit();
    }
}

echo "NOK";
