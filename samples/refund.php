<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
$refund = new \Payconn\QNBFinansbank\Model\Refund();

$refund->setTestMode(true);
$refund->setOrderId($_GET['order_id']);
$refund->setAmount($_GET['amount']);
$refund->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

$response = (new \Payconn\QNBFinansbank($token))->refund($refund);

print_r([
    'isSuccessful' => (int) $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
]);
