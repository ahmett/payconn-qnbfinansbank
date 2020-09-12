<?php

namespace Payconn\QNBFinansbank\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\HttpClient;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    /**
     * @covers \Payconn\QNBFinansbank\Model\Purchase
     */
    public function testFailure(): void
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="utf-8"?>
            <PayforResponse>
                <ErrMsg>EXAMPLE_ERROR_MESSAGE</ErrMsg>
            </PayforResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $purchase = new \Payconn\QNBFinansbank\Model\Purchase();

        $purchase->setTestMode(true);
        $purchase->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);
        $purchase->setAmount(1);
        $purchase->setInstallment(0);
        $purchase->setCreditCard(new \Payconn\Common\CreditCard('4155650100416111', '25', '01', '123'));
        $purchase->generateOrderId();

        $response = (new \Payconn\QNBFinansbank($token, $client))->purchase($purchase);

        $this->assertFalse($response->isSuccessful());
    }

    /**
     * @covers \Payconn\QNBFinansbank\Model\Purchase
     */
    public function testSuccessful(): void
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="utf-8"?>
            <PayforResponse>
                <ErrMsg>Onaylandı</ErrMsg>
            </PayforResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $purchase = new \Payconn\QNBFinansbank\Model\Purchase();

        $purchase->setTestMode(true);
        $purchase->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);
        $purchase->setAmount(1);
        $purchase->setInstallment(0);
        $purchase->setCreditCard(new \Payconn\Common\CreditCard('4155650100416111', '25', '01', '123'));
        $purchase->generateOrderId();

        $response = (new \Payconn\QNBFinansbank($token, $client))->purchase($purchase);

        $this->assertTrue($response->isSuccessful());
    }
}
