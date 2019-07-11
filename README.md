# Welcome to FasterPay PHP SDK

FasterPay PHP SDK enables you to integrate the FasterPay's Checkout Page seamlessly without having the hassle of integrating everything from Scratch. Once your customer is ready to pay, FasterPay will take care of the payment, notify your system about the payment and return the customer back to your Thank You page.

## Downloading the FasterPay PHP SDK

```sh
$ git clone https://github.com/FasterPay/fasterpay-php.git
```

## Setting up the PHP SDK for your project
```sh
$ cp fasterpay-php path-to-project/lib/fasterpay-php
```

## Initiating Payment Request using PHP SDK
```php
<?php

require_once('fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 0, // Use 1 for Test Method
]);

$form = $gateway->paymentForm()->buildForm(
    [
        'description' => 'Test order',
        'amount' => '10',
        'currency' => 'USD',
        'merchant_order_id' => time(),
        'success_url' => 'https://yourcompanywebsite.com/success',
        'pingback_url' => 'https://yourcompanywebsite.com/pingback',
        'sign_version' => 'v2' // to use version 1 please skip this param or set it 'v1'
    ],
    [
        'autoSubmit' => false,
        'hidePayButton' => false
    ]
);

echo $form;

```
For more information on the API Parameters, refer to our entire API Documentation [here](https://docs.fasterpay.com/api#section-custom-integration)

## Handling FasterPay Pingbacks

```php
<?php

require_once('fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 0, // Use 1 for Test Mode
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


```
## FasterPay Test Mode
FasterPay has a Sandbox environment called Test Mode. Test Mode is a virtual testing environment which is an exact replica of the live FasterPay environment. This allows businesses to integrate and test the payment flow without being in the live environment. Businesses can create a FasterPay account, turn on the **Test Mode** and begin to integrate the widget using the test integration keys.

### Initiating FasterPay Gateway in Test-Mode
```php
<?php

require_once('fasterpay-php/lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1
]);
```

### Questions?
* Common questions are covered in the [FAQ](https://www.fasterpay.com/support).
* For integration and API questions, feel free to reach out Integration Team via [integration@fasterpay.com](mailto:integration@fasterpay.com)
* For business support, email us at [merchantsupport@fasterpay.com](mailto:merchantsupport@fasterpay.com)
* To contact sales, email [sales@fasterpay.com](mailto:sales@fasterpay.com).
