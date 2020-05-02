<?php

require_once __DIR__.'/../vendor/autoload.php';

$token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
$authorize = new \Payconn\QNBFinansbank\Model\Authorize();

$authorize->setTestMode(true);
$authorize->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);
$authorize->setAmount(250);
$authorize->setInstallment(0);
$authorize->setCreditCard(new \Payconn\Common\CreditCard('4155650100416111', '25', '01', '123'));
$authorize->setSuccessfulUrl('http://127.0.0.1:8000/complete.php');
$authorize->setFailureUrl('http://127.0.0.1:8000/failure.php');
$authorize->generateOrderId();

$response = (new \Payconn\QNBFinansbank($token))->authorize($authorize);

if ($response->isSuccessful() && $response->isRedirection()) {
    echo $response->getRedirectForm();
}
