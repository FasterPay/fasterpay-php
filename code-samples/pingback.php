<?php

require($_SERVER["DOCUMENT_ROOT"] . '/fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway(array(
    'publicKey'     => '<your-public-key>',
    'privateKey'    => '<your-private-key>',
    'isTest'        => 1
));

$pingbackData = $_REQUEST;
if(!empty($pingbackData)){

    if($gateway->pingback()->validate(
      array("apiKey" => $_SERVER["HTTP_X_APIKEY"]))
    ){
        #TODO: Write your code to deliver contents to the End-User.
        echo "OK"; exit();
    }
}

echo "NOK";
