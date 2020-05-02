<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
$complete = new \Payconn\QNBFinansbank\Model\Complete();

$complete->setTestMode(true);
$complete->setReturnParams([
    'RequestGuid' => $_POST['RequestGuid'],
    'OrderId' => $_POST['OrderId'],
]);

$response = (new \Payconn\QNBFinansbank($token))->complete($complete);

print_r([
    'isSuccessful' => $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
    'orderId' => $response->getOrderId(),
]);
