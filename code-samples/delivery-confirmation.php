<?php

require_once('../lib/autoload.php');

$gateway = new FasterPay\Gateway([
    'publicKey' => '<your-public-key>',
    'privateKey' => '<your-private-key>',
    'isTest' => 1,
]);

$payload = [
    'payment_order_id' => '12123231',
    'merchant_reference_id' => '989898',
    'sign_version' => 'v2',
    'status' => 'order_shipped',
    'refundable' => 1,
    'notify_user' => 1,
    'product_description' => 'Golden Ticket',
    'details' => 'Product Details go here',
    'reason' => 'Shipped Today',
    'estimated_delivery_datetime' => date('Y-m-d H:i:s O'),
    'carrier_tracking_id' => '901389012830918301',
    'carrier_type' => 'FedEx',
    'shipping_address' => [
        'country_code' => 'US',
        'city' => 'San Francisco',
        'zip' => '91004',
        'state' => 'CA',
        'street' => 'Market Street',
        'phone' => '14159883933',
        'first_name' => 'Jon',
        'last_name' => 'Doe',
        'email' => 'jon.doe@example.com'
    ],
    'type' => 'physical',
    'public_key' => $gateway->getConfig()->getPublicKey(),
];

$payload["hash"] = $gateway->signature()->calculateWidgetSignature($payload);

try {
    $response = $gateway->callApi(
        'api/v1/deliveries',
        $payload,
        'POST',
        ['content-type: application/json']
    );
} catch (FasterPay\Exception $e) {
    echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
    exit();
}

if ($response->isSuccessful()) {
    echo $response->getRawResponse();
} else {
    echo $response->getRawResponse();
}