<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
$cancel = new \Payconn\QNBFinansbank\Model\Cancel();

$cancel->setTestMode(true);
$cancel->setOrderId($_GET['order_id']);
$cancel->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

$response = (new \Payconn\QNBFinansbank($token))->cancel($cancel);

print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
]);
