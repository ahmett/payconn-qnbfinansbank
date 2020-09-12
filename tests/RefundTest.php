<?php

namespace Payconn\QNBFinansbank\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\HttpClient;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    /**
     * @covers \Payconn\QNBFinansbank\Model\Refund
     */
    public function testFailure(): void
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="utf-8"?>
            <PayforResponse>
                <ErrMsg>Bu işlem geri alınamaz, lüften asıl işlemi iptal edin.</ErrMsg>
            </PayforResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $refund = new \Payconn\QNBFinansbank\Model\Refund();

        $refund->setTestMode(true);
        $refund->setOrderId('EXAMPLE_ORDER_ID');
        $refund->setAmount(1);
        $refund->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

        $response = (new \Payconn\QNBFinansbank($token, $client))->refund($refund);

        $this->assertFalse($response->isSuccessful());
    }

    /**
     * @covers \Payconn\QNBFinansbank\Model\Refund
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
        $refund = new \Payconn\QNBFinansbank\Model\Refund();

        $refund->setTestMode(true);
        $refund->setOrderId('EXAMPLE_ORDER_ID');
        $refund->setAmount(1);
        $refund->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

        $response = (new \Payconn\QNBFinansbank($token, $client))->refund($refund);

        $this->assertTrue($response->isSuccessful());
    }
}
