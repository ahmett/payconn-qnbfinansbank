<?php

namespace Payconn\QNBFinansbank\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\HttpClient;
use PHPUnit\Framework\TestCase;

class CancelTest extends TestCase
{
    public function testFailure(): void
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="utf-8"?>
            <PayforResponse>
                <ErrMsg>Seçili İşlem Bulunamadı!</ErrMsg>
            </PayforResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $cancel = new \Payconn\QNBFinansbank\Model\Cancel();

        $cancel->setTestMode(true);
        $cancel->setOrderId('EXAMPLE_ORDER_ID');
        $cancel->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

        $response = (new \Payconn\QNBFinansbank($token, $client))->cancel($cancel);

        $this->assertFalse($response->isSuccessful());
    }

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
        $cancel = new \Payconn\QNBFinansbank\Model\Cancel();

        $cancel->setTestMode(true);
        $cancel->setOrderId('EXAMPLE_ORDER_ID');
        $cancel->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);

        $response = (new \Payconn\QNBFinansbank($token, $client))->cancel($cancel);

        $this->assertTrue($response->isSuccessful());
    }
}
