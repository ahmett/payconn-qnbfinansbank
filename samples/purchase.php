<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
$purchase = new \Payconn\QNBFinansbank\Model\Purchase();

$purchase->setTestMode(true);
$purchase->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);
$purchase->setAmount(1);
$purchase->setInstallment(0);
$purchase->setCreditCard(new \Payconn\Common\CreditCard('4155650100416111', '25', '01', '123'));
$purchase->generateOrderId();

$response = (new \Payconn\QNBFinansbank($token))->purchase($purchase);

print_r([
    'isSuccessful' => $response->isSuccessful(),
    'message' => $response->getResponseMessage(),
    'code' => $response->getResponseCode(),
    'orderId' => $response->getOrderId(),
]);
