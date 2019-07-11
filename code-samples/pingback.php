<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);

$signVersion = \FasterPay\Services\Signature::SIGN_VERSION_1;
if (!empty($_SERVER['HTTP_X_FASTERPAY_SIGNATURE_VERSION'])) {
    $signVersion = $_SERVER['HTTP_X_FASTERPAY_SIGNATURE_VERSION'];
}

$pingbackData = null;
$validationParams = [];

switch ($signVersion) {
    case \FasterPay\Services\Signature::SIGN_VERSION_1:
        $validationParams = ["apiKey" => $_SERVER["HTTP_X_APIKEY"]];
        $pingbackData = $_REQUEST;
        break;
    case \FasterPay\Services\Signature::SIGN_VERSION_2:
        $validationParams = [
            'pingbackData' => file_get_contents('php://input'),
            'signVersion' => $signVersion,
            'signature' => $_SERVER["HTTP_X_FASTERPAY_SIGNATURE"],
        ];
        $pingbackData = json_decode(file_get_contents('php://input'), 1);
        break;
    default:
        exit('NOK');
}

if (empty($pingbackData)) {
    exit('NOK');
}

if (!$gateway->pingback()->validate($validationParams)) {
    exit('NOK');
}

//echo "<pre>";
//print_r($pingbackData);
//echo '</pre>';
#TODO: Write your code to deliver contents to the End-User.
echo "OK";
exit();


