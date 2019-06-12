<?php
require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey' => 'a7b7fe9a2ca2c717720577b5243a565d',
    'privateKey' => '69d7686cf2fe45d4f12c207d9c4b9845',
    'isTest' => 0
));

$pingbackData = $_REQUEST;
if (!empty($pingbackData)) {

    if ($gateway->pingback()->validate(
        array("apiKey" => $_SERVER["HTTP_X_APIKEY"]))
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
